@extends('front.main_layout')

@section('css')

@endsection
@section('main')


	<!-- About Page -->
	<div class="gallery__page">
		<div class="gallery__warp pl-6 pr-6">
			<div class="row" style=" padding-left:150px;padding-right:100px" >

                @foreach($blogs as $gal)

				<div class="col-lg-3 col-md-4 col-sm-6">

					<a  href="/blog-detail/{{Str::slug($gal['title'])}}/{{$gal['id']}}" >
                        <h5 style="margin-bottom:20px">   {{$gal['title']}}</h5>
						<img src="{{url('post_images/500x500'.$gal['image'])}}" alt="" style="width:450px;">
					</a>
                    <p style="margin-top:20px">
                        {{$gal['prologue']}}
                    </p>
				</div>

                @endforeach

			</div>
		</div>
	</div>

    @include('front.partials.paging')
	<!-- About Page end -->


	<!-- About Page end -->
@endsection

@section('scripts')





@endsection
