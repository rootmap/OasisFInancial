<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en-US"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en-US"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="en-US"><![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en-US">
<!--<![endif]-->

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Neutrix.Systems">
	<link rel="stylesheet" href="{{asset('mod/css/animate.min.css')}}">
	<title>@yield('title') | Oasis Financial | (877) 333 6680</title>
    <meta name="description" content="Get legal funding within 24 hours, once approved, for your bills. Even if you lose your case, you still win with Oasis - you get to keep the money." />
	<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
	
    @include('site.include.extra.header')
    @yield('css')
</head>

<body class="home page-template page-template-templates page-template-template-home page-template-templatestemplate-home-php page page-id-48 not-whitepage">
	<div id="header">
		@include('site.include.content.top-barcum')
		@include('site.include.content.top-nav')
	</div>
	@yield('content')
	@include('site.include.extra.fotter')
	@yield('js')
</body>

</html>