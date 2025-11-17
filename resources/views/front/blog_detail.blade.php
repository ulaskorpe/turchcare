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


<div class="blog__single__page">
    <div class="blog__slider">
        @foreach($image_array as $item)
        @if(!empty($blog[$item])  ))
            <div class="blog__slider__item">

                <a href="#">
                    <img src="{{ url('post_images/'.$blog[$item]) }}" alt="" onclick="showimage('{{ $blog[$item] }}')">
                </a>
            </div>
        @endif
    @endforeach

    </div>
    <article class="blog__article">
        <div class="blog__container">
            <div class="blog__header">

                <h2 class="blog__single__title">{{$blog['title']}}</h2>
                <div class="blog__metas">

                    <div class="blog__meta"> {{$date}}</div>
                    <div class="blog__meta">{{$count}} {{__('front.comment')}}</div>
                </div>
            </div>
            <p>

                {{$blog['content']}}
            </p>
        </div>
        {{-- <blockquote>
            <p>Sed dignissim justo. Suspendisse fermentum erat. Duis consequat tortor. Mauris ut tellus a dolor. Suspendisse nec tellus. Donec quis lacus magna, sollicitudin id, turpis. Mauris in velit vel sollicitudin justo. Proin vitae massa nec cursus magna. Fusce blandit eu, ullamcorper in.</p>
            <h4>Marvin Barber</h4>

        </blockquote> --}}
        <div class="blog__container">
            <h4>  {{$blog['second_title']}}</h4>
            <p>   {{$blog['content_2']}}</p>
        </div>


        <div class="">
            @if(!empty($blog['youtube_video']))
            <div class="row p-0 m-0" style="text-align: center;">
                <div class="col-4"></div>
                <div class="col-4">

                        <img
                            style="cursor: pointer; "
                            class="youtube-thumb"
                            data-video-id="{{$blog['youtube_video']}}"
                            src="https://img.youtube.com/vi/{{$blog['youtube_video']}}/hqdefault.jpg"
                            alt="">

                </div>
                <div class="col-4"></div>

            </div>
            @endif
        </div>

        <div class="blog__container post__footer">
            <div class="row">
                <div class="col-md-6">
                    <div class="post__tags">
                        {{-- <a href="#">Camera</a>
                        <a href="#">Photography</a>
                        <a href="#">Tips</a> --}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="post__share">
                        <span>{{__('front.share')}}:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank"><i class="fa fa-linkedin"></i></a>
                        <a href="https://www.instagram.com/" target="_blank"><i class="fa fa-instagram"></i></a> <!-- Instagram doğrudan paylaşma linki yok -->
                        <a href="https://www.youtube.com/" target="_blank"><i class="fa fa-youtube-play"></i></a> <!-- YouTube doğrudan paylaşma linki yok -->
                    </div>
                </div>
            </div>
        </div>
        <div class="blog__container comment__area">
            <h2>{{__('front.leave_a_comment')}}</h2>


                <form class="comment__form" id="contact-form-x" name="contact-form-x" action="#"  method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="blog_id" id="blog_id" value="{{$blog['id']}}">
                    <input type="hidden" name="ip_address" id="ip_address" value="{{ request()->ip() }}">

                <div class="row">
                    <div class="col-lg-4">
                        <input type="text" id="name" name="name" placeholder="{{__('front.enter_name')}}">
                    </div>
                    <div class="col-lg-4">
                        <input type="text" id="email" name="email" placeholder="{{__('front.enter_email')}}">
                    </div>
                    <div class="col-lg-4">
                        <input type="text" id="phone" name="phone" placeholder="{{__('front.placeholder.phone')}}">
                    </div>
                    <div class="col-lg-12">
                        <textarea id="message" name="message" placeholder="{{__('front.your_comment')}}"></textarea>

                        <button class="site-btn" onclick="submitForm()">{{__('front.placeholder.submit')}}</button>
                    </div>
                </div>
            </form>
            <div style="height: 50px"></div>
            @foreach($comments as $item)
            <div class="row" style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                <div style="font-size: 16px; margin-bottom: 8px;">
                    {{ $item['message'] }}
                </div>
                <hr>
                <div style="font-size: 14px; color: #555; text-align: right;">
                    {{ $item['name'] }} — {{ \Carbon\Carbon::parse($item->created_at)->format('d.m.Y H:i') }}
                </div>
            </div>
            @endforeach

        </div>
        <div class="container recent__post">
            <div class="text-center">
                <h2>{{__('front.you_may_also_like')}}</h2>
            </div>
            <div class="row">
                @foreach($others as $item)
                <div class="col-md-4">
                    <div class="blog__item set-bg" data-setbg="{{url('post_images/'.$item['image'])}}">
                        <div class="blog__content">
                            <div class="blog__date">{{ \Carbon\Carbon::parse($item->created_at)->format('d.m.Y H:i') }} </div>
                            <h4><a href="{{url('blog-detail/'.Str::slug($item['title']).'/'.$item['id'])}}">{{$item['title']}}</a></h4>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </article>
</div>
<!-- Blog Page end -->



	<!-- About Page -->
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
<script src="{{url('/assets/js/sweetalert2@11.js')}}" type="text/javascript"></script>
<script src="{{url('/assets/js/saveV3.js')}} " type="text/javascript"></script>

<script>
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

function submitForm(){
    $('#contact-form-x').submit();
}

        $('#contact-form-x').submit(function(e) {
                    e.preventDefault();
                    var error = false;


                    if ($('#name').val() == '') {

        $('#name').focus();
        Swal.fire({
            icon: 'error',
            text: "{{__('front.enter_name')}}"
        });

        error = true;
        return false;
        }

        if ($('#surname').val() == '') {

        $('#surname').focus();
        Swal.fire({
            icon: 'error',
            text: "{{__('front.enter_surname')}}"
        });

        error = true;
        return false;
        }

                    if ($('#email').val() == '') {
                        $('#email').focus();
                        Swal.fire({
                            icon: 'error',
                            text: "{{__('front.enter_email')}}"
                        });
                        error = true;
                        return false;
                     }else{
                        if (!validateEmail($('#email').val())) {
                            $('#email').focus();
                            $('#email').val('');
                        Swal.fire({
                            icon: 'error',
                            text: "{{__('front.email_not_valid')}}"
                        });
                        error = true;
                        return false;
                        }

                     }


        if ($('#message').val() == '') {

        $('#message').focus();
        Swal.fire({
            icon: 'error',
            text: "{{__('front.enter_message')}}"
        });

        error = true;
        return false;
        }

                    if (error) {
                        return false;
                    }

                    //function save(formData,route,formID,btn,reload) {
                    var formData = new FormData(this);

                    save(formData,'{{ route('comment-post') }}','contact-form-x','','1');


                });


    // Youtube tıklanınca
    $('.youtube-thumb').click(function() {
        var videoId = $(this).data('video-id');
        var videoUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';

        $('#customVideo').attr('src', videoUrl).show();
        $('#customImage').hide();

        $('#customModal').fadeIn();
    });

    // Resim tıklanınca
function showimage(img){

        $('#customImage').attr('src', '/post_images/' + img).show();
        $('#customVideo').attr('src', '').hide();

        $('#customModal').fadeIn();
    };

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
