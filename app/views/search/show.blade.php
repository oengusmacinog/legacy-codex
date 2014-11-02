@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div id="sidebar" class="col-md-3">
				<nav class="toc">
					{{ $toc }}
				</nav>
			</div>

			<div class="col-md-9 documentation">
				<h1>Search results for <small>{{ $search }}</small></h1>

				<div id="search-results">
					@if (count($results) > 0)
						@foreach ($results as $result)
							<ul>
								<li>
									<a href="{{ url($result['url']) }}">{{ markdown($result['title']) }}</a>
								</li>
							</ul>							
						@endforeach
					@else
						<p>
							Shucks, no results found Batman.
						</p>
					@endif
				</div>
			</div>
		</div>
	</div>
@stop