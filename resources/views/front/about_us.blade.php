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
	<section class="about__page">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="about__text">
                                <h3 class="about__title">{{__('front.about_us')}}</h3>
                                <div class="about__meta">
                                    <img src="{{url('post_images/300x400'.$about_us['image'])}}" alt="">
                                    <div class="about__meta__info">
                                        <h5>{{$about_us['title']}}</h5>
                                        <p>{{$about_us['second_title']}}</p>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-lg-6">

                            <div class="about__text">
                                <p>
                                    {{$about_us['content']}}
                                </p>
                                <div class="col-lg-12">
                                    @if($about_us['second_image'])
                                    <img src="{{url('post_images/'.$about_us['second_image'])}}" alt="" >
                                    @endif
                                </div>


                            </div>


                        </div>
                        <div class="col-lg-6">

                            <div class="about__text">

                                <p>   {{$about_us['content_2']}}</p>

                            </div>

                        </div>


                    </div>

				</div>
				<div class="col-lg-12" style="margin-top:50px">
					<div class="experience__text">
						<h3 class="about__title">{{__('front.experiences')}}</h3>
                        <div class="row">
                            @foreach($experiences as $exp)
                            <div class="col-lg-4 experience__item">
                                <h4>{{$exp['title']}}</h4>
                                @if($exp['image'])


                                <figure class="image">
                                    <img
                                        style="cursor: pointer;width:100%"
                                        class="img-thumb"
                                        data-image-url="{{$exp['image']}}"
                                        src="{{url('post_images/300x400'.$exp['image'])}}"
                                        alt=""
                                        style="max-height: 350px">
                                </figure>

                                @endif
                                <p>
                                    {{$exp['content']}}

                                </p>
                                @if($exp['youtube_video'])

                                <div class="image-box">



                                    <figure class="image"> <img
         style="  cursor: pointer;"
             class="youtube-thumb"
             data-video-id="{{$exp['youtube_video']}}"
                                        src="https://img.youtube.com/vi/{{$exp['youtube_video']}}/hqdefault.jpg " alt="" style="max-height: 350px"> </figure>
                                </div>
                                @endif


                            </div>
                            @endforeach
                        </div>


					</div>
				</div>

			</div>
		</div>
	</section>


    <div id="customModal" style="display: none;">
        <div id="modalOverlay"></div>
        <div id="modalContent">
            <span id="closeModal">&times;</span>

            <!-- Video iframe -->
            <iframe id="customVideo" width="800" height="450" frameborder="0"
                    allow="autoplay; encrypted-media" allowfullscreen style="display: none;"></iframe>

            <!-- Image display -->
            <img id="customImage" src="" alt="Large image" style="max-width: 100%; max-height: 90vh; display: none; border-radius: 8px; box-shadow: 0 0 20px rgba(0,0,0,0.6);">
        </div>
    </div>

	<!-- About Page end -->
@endsection

@section('scripts')

<script>

    // Youtube tıklanınca
    $('.youtube-thumb').click(function() {
        var videoId = $(this).data('video-id');
        var videoUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';

        $('#customVideo').attr('src', videoUrl).show();
        $('#customImage').hide();

        $('#customModal').fadeIn();
    });

    // Resim tıklanınca
    $('.img-thumb').click(function() {
        var imageUrl = $(this).data('video-id'); // burada sen image yolunu data-video-id içine koymuşsun, ama bu isim kafa karıştırır.
                                                // İstersen data-image-url şeklinde daha anlamlı yapabiliriz.

        $('#customImage').attr('src', '/post_images/' + imageUrl).show();
        $('#customVideo').attr('src', '').hide();

        $('#customModal').fadeIn();
    });

    // Modal kapatma
    $('#closeModal, #modalOverlay').click(function() {
        $('#customVideo').attr('src', '').hide();
        $('#customImage').attr('src', '').hide();
        $('#customModal').fadeOut();
    });


$('.img-thumb').click(function() {
    var imageUrl = $(this).data('image-url');

    $('#customImage').attr('src', '/post_images/' + imageUrl).show();
    $('#customVideo').attr('src', '').hide();

    $('#customModal').fadeIn();
});
    </script>




@endsection