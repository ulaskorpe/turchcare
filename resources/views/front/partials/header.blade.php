	<!-- Header Section -->
	<header class="header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4 col-md-3 order-2 order-sm-1">
					<div class="header__social">
						<a href="{{__('front.facebook_link')}}" target="_blank"><i class="fa fa-facebook"></i></a>
						<a href="{{__('front.twitter_link')}}" target="_blank"><i class="fa fa-twitter"></i></a>
						<a href="{{__('front.instagram_link')}}" target="_blank"><i class="fa fa-instagram"></i></a>
						<a href="{{__('front.youtube_link')}}" target="_blank"><i class="fa fa-youtube"></i></a>
						<a href="{{__('front.linkedin_link')}}" target="_blank"><i class="fa fa-linkedin"></i></a>
					</div>
				</div>
				<div class="col-sm-4 col-md-6 order-1  order-md-2 text-center">
					<a href="/" class="site-logo">
						<img src="{{url('post_images/'.$top_banner['image'])}}" alt="Esrin Özgüler" style="width: 100px">
					</a>
				</div>
				<div class="col-sm-4 col-md-3 order-3 order-sm-3">
				 <div class="header__switches">

						<a href="#" class="nav-switch"><i class="fa fa-bars"></i></a>

					</div>
				</div>
			</div>


			<nav class="main__menu">
				<ul class="nav__menu">
					<li><a href="/"  @if($active=='home') class="menu--active" @endif>{{__('front.menu.home')}}</a></li>
					<li><a href="{{$routes['about_us'][session()->get('selectedLang')]}}" @if($active=='about') class="menu--active" @endif>{{__('front.menu.about')}}</a></li>
					<li><a href="{{$routes['galleries'][session()->get('selectedLang')]}}" @if($active=='gallery') class="menu--active" @endif>{{__('front.menu.gallery')}}</a></li>
					<li><a href="{{$routes['videos'][session()->get('selectedLang')]}}" @if($active=='videos') class="menu--active" @endif>{{__('front.menu.videos')}}</a></li>
					<li><a href="{{$routes['blogs'][session()->get('selectedLang')]}}" @if($active=='blogs') class="menu--active" @endif>{{__('front.menu.blogs')}}</a>
                        {{-- <ul class="sub__menu">
							<li><a href="{{$routes['about_us'][session()->get('selectedLang')]}}">Blog Single</a></li>
						</ul> --}}
                    </li>
					<li><a href="{{$routes['contact'][session()->get('selectedLang')]}}" @if($active=='contact') class="menu--active" @endif>{{__('front.menu.contact')}}</a></li>

				</ul>
			</nav>
		</div>
	</header>
	<!-- Header Section end -->
