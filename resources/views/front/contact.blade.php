@extends('front.main_layout')

@section('css')

@endsection
@section('main')

	<!-- Contact Page -->
	<section class="contact__page">
		<div class="contact__warp">
			<div class="row">
				<div class="col-md-6">
					<h2> {{$slut['title']}}</h2>
					<div class="contact__social">




                        <a href="{{__('front.facebook_link')}}" target="_blank"><i class="fa fa-facebook"></i></a>
						<a href="{{__('front.twitter_link')}}" target="_blank"><i class="fa fa-twitter"></i></a>
						<a href="{{__('front.instagram_link')}}" target="_blank"><i class="fa fa-instagram"></i></a>
						<a href="{{__('front.youtube_link')}}" target="_blank"><i class="fa fa-youtube"></i></a>
						<a href="{{__('front.linkedin_link')}}" target="_blank"><i class="fa fa-linkedin"></i></a>


					</div>
				</div>
				<div class="col-md-6">
					<div class="contact__text">
						<p>{{$slut['prologue']}}</p>
					</div>
				</div>
			</div>

            <form class="contact__form" id="contact-form-x" name="contact-form-x" action="#"  method="post" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                <input type="hidden" name="ip_address" id="ip_address" value="{{ request()->ip() }}">

                <input type="text"  id="name" name="name" placeholder="{{__('front.placeholder.name')}} {{__('front.placeholder.surname')}}">
                <input type="hidden"  id="surname" name="surname" value="..">
                <input type="text"  id="email"   name="email" placeholder="{{__('front.placeholder.email')}}" >
				<input type="text" class="form-control" id="phone"   name="phone" placeholder="{{__('front.placeholder.phone')}}">
                <textarea id="message"
                placeholder="{{__('front.placeholder.message')}}"
                id="message" name="message"></textarea>
                <input type="submit" value="{{__('front.placeholder.submit')}}" class="site-btn" style="color:white;width:150px">

			</form>
		</div>
	</section>
	<!-- Contact Page end -->


	<!-- About Page end -->
@endsection

@section('scripts')
<script src="{{url('/assets/js/sweetalert2@11.js')}}" type="text/javascript"></script>
<script src="{{url('/assets/js/saveV3.js')}} " type="text/javascript"></script>


@include('front.partials.contactformscript')


@endsection
