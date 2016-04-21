@extends('layouts.master')

@section('content')
	<div class="col-lg-12 documentation">
		@if (isset($meta['breadcrumbs']))
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
				@foreach ($meta['breadcrumbs'] as $breadcrumb)
					<li>{{ $breadcrumb }}</li>
				@endforeach
				</ol>
			</div>
		</div>
		@endif
		
		<div class="row">
			<div class="col-lg-12">
				<span class="pull-left">
					@if (isset($meta['author']))
						<small><span class="glyphicon glyphicon-user"></span> Authored By <b>{{ $meta['author'] }}</b></small>
					@endif
				</span>

				<span class="pull-right">
					<small><span class="glyphicon glyphicon-calendar"></span> {{ $lastUpdated }}</small>
				</span>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="col-md-3" id="tocify"></div>

				{{ $content }}

				@if (isset($meta['resources']))

				<h4>Resources</h4>
				<hr>

					@foreach ($meta['resources'] as $resource)
						{{ $resource }}<br/>
					@endforeach

				@endif

				@include('partials.footer')
			</div>
		</div>
	</div>
@stop
