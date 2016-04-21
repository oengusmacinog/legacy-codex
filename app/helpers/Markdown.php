<?php

class Markdown
{
	/**
	 * Convert text from Markdown to HTML.
	 *
	 * @param  string $text
	 * @param string  $pathPrefix
	 * @return string
	 */
	public static function parse($text, $pathPrefix = '')
	{
		$parsedown = new \Parsedown();
		$parsed   = self::removeMeta($text);
		$basePath = url('/' . ltrim($pathPrefix, '/'));
		$rendered = $parsedown->text($parsed);

		// Replace absolute relative paths (paths that start with / but not //)
		$rendered = preg_replace('/href=\"(\/[^\/].+?).md(#?.*?)\"/', "href=\"$basePath$1$2\"", $rendered);

		// Replace relative paths (paths that don't start with / or http://, https://, //, etc)
		$rendered = preg_replace('/href=\"(?!.*?\/\/)(.+?).md(#?.*?)\"/', "href=\"$basePath/$1$2\"", $rendered);

		return $rendered;
	}

	public static function removeMeta($content)
	{
		$regexDocblockWhole = "/(?s)(\/\*(?:(?!\*\/).)+\*\/)/";

		return preg_replace($regexDocblockWhole, '', $content);
	}

	/**
	 * Extracts and parses metadata from the document.
	 *
	 */
	public static function parseMeta($content, $extract = false)
	{
		$regexDocblockWhole = "/(?s)(\/\*(?:(?!\*\/).)+\*\/)/";
		$regexDocblockMeta  = "/(\w+):\s+(.*)\r?\n/m";

		preg_match_all($regexDocblockWhole, $content, $metadata);

		$metadata = implode(' ', $metadata[1]);

		if (preg_match_all($regexDocblockMeta, $metadata, $matches)) {
			$meta = array_combine($matches[1], $matches[2]);
		}

		if (isset($meta)) {
			if (isset($meta['Breadcrumbs'])) {
				$breadcrumbsRaw = explode(', ', $meta['Breadcrumbs']);

				foreach ($breadcrumbsRaw as $breadcrumb) {
					if (preg_match_all("/\[([^]]*)\] *\(([^)]*)\)/i", $breadcrumb, $reference)) {
						$breadcrumbs[] = '<a href="'.substr($reference[2][0], 0, -3).'">'.$reference[1][0].'</a>';
					} else {
						$breadcrumbs[] = $breadcrumb;
					}
				}

				$meta['Breadcrumbs'] = $breadcrumbs;
			}

			if (isset($meta['Resources'])) {
				$resourcesRaw = explode('; ', $meta['Resources']);

				foreach ($resourcesRaw as $resource) {
					if (preg_match_all("/\[([^]]*)\] *\(([^)]*)\)/i", $resource, $reference)) {
						$resources[] = '<small><strong><a href="'.$reference[2][0].'">'.$reference[1][0].' <span class="glyphicon glyphicon-link" style="color: #777;"></span></a></strong></small>';
						// $resources[] = '<small><strong><a href="'.substr($reference[2][0], 0, -3).'">'.$reference[1][0].' <span class="glyphicon glyphicon-link" style="color: #777;"></span></a></strong></small>';
					} else {
						$resources[] = $resource;
					}
				}

				$meta['Resources'] = $resources;
			}
			return array_change_key_case($meta, CASE_LOWER);
		}

		return null;		
	}
}
