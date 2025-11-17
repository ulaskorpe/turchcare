@extends('front.main_layout')

@section('css')

<style>
    #customModal {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 9999;
    }

    #modalOverlay {
        position: absolute;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.8);
    }

    #modalContent {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10000;
    }

    #modalContent iframe {
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0,0,0,0.6);
    }

    #closeModal {
        position: absolute;
        top: -30px;
        right: -30px;
        font-size: 32px;
        color: white;
        cursor: pointer;
    }
    </style>

@endsection
@section('main')


	<!-- About Page -->
	<div class="gallery__page">
		<div class="gallery__warp">
			<div class="row">
                @foreach($galleries as $gal)
				<div class="col-lg-3 col-md-4 col-sm-6">
                 <h5 style="margin-bottom:20px">   {{$gal['title']}}</h5>
					<a  href="/gallery-detail/{{Str::slug($gal['title'])}}/{{$gal['id']}}" >
						<img src="{{url('post_images/450x500'.$gal['image'])}}" alt="" style="width:450px;">
					</a>
                    <p style="margin-top:20px">
                        {{$gal['prologue']}}
                    </p>
				</div>
                @endforeach
			</div>
		</div>
	</div>
	<!-- About Page end -->
    @include('front.partials.paging')

	<!-- About Page end -->
@endsection

@section('scripts')





@endsection