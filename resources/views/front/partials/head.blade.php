<head>


    <title>{{(!empty($title)) ? $title : __('front.title')}}</title>
	<meta charset="UTF-8">
	<meta name="description" content="{{ (!empty($description)) ? $description : $top_banner['description']}}">
	<meta name="keywords" content="{{ (!empty($keywords)) ? $keywords : $top_banner['keywords']}}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--
    Favicons
    =============================================
    -->
    <link  rel="apple-touch-icon" sizes="57x57" href="{{url('assets/images/favicons/apple-icon-57x57.png')}}"/>
    <link  rel="apple-touch-icon" sizes="60x60"  href="{{url('assets/images/favicons/apple-icon-60x60.png')}}"/>
    <link rel="apple-touch-icon" sizes="72x72" href="{{url('assets/images/favicons/apple-icon-72x72.png')}}"/>
    <link rel="apple-touch-icon" sizes="76x76"  href="{{url('assets/images/favicons/apple-icon-76x76.png')}}"/>
    <link rel="apple-touch-icon" sizes="114x114"  href="{{url('assets/images/favicons/apple-icon-114x114.png')}}"/>
    <link rel="apple-touch-icon" sizes="120x120"  href="{{url('assets/images/favicons/apple-icon-120x120.png')}}"/>
    <link rel="apple-touch-icon" sizes="144x144" href="{{url('assets/images/favicons/apple-icon-144x144.png')}}"/>
    <link rel="apple-touch-icon" sizes="152x152"  href="{{url('assets/images/favicons/apple-icon-152x152.png')}}"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('assets/images/favicons/apple-icon-180x180.png')}}"/>
    <link rel="icon" type="image/png"  sizes="192x192" href="{{url('assets/images/favicons/android-icon-192x192.png')}}"/>
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('assets/images/favicons/favicon-32x32.png')}}"/>
    <link rel="icon" type="image/png" sizes="96x96" href="{{url("assets/images/favicons/favicon-96x96.png")}}"/>
    <link rel="icon" type="image/png" sizes="16x16" href="{{url("assets/images/favicons/favicon-16x16.png")}}"/>
    <link rel="stylesheet" href="{{url('assets/images/favicons/apple-icon-57x57.png')}}"/>
    <link rel="stylesheet" href="{{url('assets/images/favicons/apple-icon-57x57.png')}}"/>
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{url('assets/images/favicons/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">

    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Volkhov:400i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">


    <link rel="stylesheet" href="{{ url('assets/lib/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/lib/animate.css/animate.css') }}">
    <link rel="stylesheet" href="{{ url('assets/lib/components-font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/lib/et-line-font/et-line-font.css') }}">
    <link rel="stylesheet" href="{{ url('assets/lib/flexslider/flexslider.css') }}">
    <link rel="stylesheet" href="{{ url('assets/lib/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/lib/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/lib/magnific-popup/dist/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ url('assets/lib/simple-text-rotator/simpletextrotator.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/colors/default.css') }}">


    @yield('css')

  </head>
