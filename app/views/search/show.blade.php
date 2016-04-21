@extends('layouts.master')

@section('content')
	<div class="col-md-12 documentation">
		<h1>Search results for <small>"{{ $search }}"</small></h1>

		<div id="search-results">
			@if (count($results) > 0)
				<ol>
					@foreach ($results as $result)
						<li>
							<a href="{{ url($result['url']) }}">{{ Markdown::parse($result['title']) }}</a>
						</li>
					@endforeach
				</ol>
			@else
				<p>
					Shucks, no results found Batman.
				</p>
			@endif
		</div>
	</div>
@stop
