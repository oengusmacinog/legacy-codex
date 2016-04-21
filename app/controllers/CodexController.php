<?php

class CodexController extends BaseController
{
	/**
	 * The codex model.
	 *
	 * @var CodexRepositoryInterface
	 */
	protected $codex;

	/**
	 * The default manual.
	 *
	 * @var string
	 */
	protected $defaultManual;

	/**
	 * The default version.
	 *
	 * @var string
	 */
	protected $defaultVersion;

	/**
	 * The default root url.
	 *
	 * @var string
	 */
	protected $rootUrl;

    /**
     * Create a new controller instance.
     *
     * @param  CodexRepositoryInterface $codex
     * @return \CodexController
     */
	public function __construct(CodexRepositoryInterface $codex)
	{
		$this->codex = $codex;

		$this->defaultManual  = $this->codex->getDefaultManual();
		$this->defaultVersion = $this->codex->getDefaultVersion($this->defaultManual);

		$this->rootUrl = Config::get('codex.route_base').'/'.$this->defaultManual.'/'.$this->defaultVersion;
	}

	/**
	 * Show the root documentation page.
	 *
	 * @return Redirect
	 */
	public function index()
	{
		return Redirect::to(url($this->rootUrl));
	}

	/**
	 * Show a documentation page.
	 *
	 * @return Response
	 */
	public function show($manual, $version = null, $page = null)
	{
		if (is_null($version)) {
			return Redirect::to(url($manual.'/'.$this->codex->getDefaultVersion($manual)));
		}

		$toc            = $this->codex->getToc($manual, $version);
		$content        = $this->codex->get($manual, $version, $page ?: 'introduction');
		$meta           = $this->codex->getMeta($manual, $version, $page ?: 'introduction');
		$lastUpdated    = $this->codex->getUpdatedTimestamp($manual, $version, $page ?: 'introduction');
		$currentManual  = $manual;
		$currentVersion = $version;
		$manuals        = $this->codex->getManuals();
		$versions       = $this->codex->getVersions($manual);

		// dd($meta);

		return View::make('codex.show', compact(
			'toc',
			'content',
			'meta',
			'lastUpdated',
			'currentManual',
			'currentVersion',
			'manuals',
			'versions'
		));
	}
}
