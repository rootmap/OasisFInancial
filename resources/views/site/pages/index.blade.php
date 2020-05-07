@extends('site.layout.master')
@section('title','Home')
@section('css')
    <link media="all" href="{{asset('mod/css/index.css')}}" rel="stylesheet" />
@endsection
@section('content')
    <div id="content-wrap">
		<h1 style="display:none; opacity:0; margin:0; padding:0; width:0; height:0; font-size:0;">Oasis Financial</h1>
		<div id="page-content">
			@include('site.include.content.slider')
			@include('site.include.content.trustpilot')
			@include('site.include.content.howwehelp')
			@include('site.include.content.betterdays')
			@include('site.include.content.fundingyouneed')
			<div class="section py-5 py-md-6">
				@include('site.include.content.youarenotalone')
				@include('site.include.content.helpformanycasetypes')
				@include('site.include.content.neversettleforless')
				@include('site.include.content.applynowform')
				@include('site.include.content.glossary')
			</div>
		</div>
	</div>
@endsection

@section('js')
    <script type='text/javascript' src='{{asset('mod/js/typeanimation.js?ver=5.3.2')}}'></script>
@endsection