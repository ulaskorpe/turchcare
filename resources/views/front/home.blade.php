@extends('front.main_layout')


@section('main')

    <section class="home-section home-parallax home-fade" id="home">
      <div class="hero-slider">
        <ul class="slides">
            @foreach($sliders as $item)
          <li class="bg-dark-30 bg-dark" style="background-image:url({{url('post_images/'.$item['image'])}});">
            <div class="titan-caption">
              <div class="caption-content">
                <div class="font-alt mb-30 titan-title-size-1">{{$item['title']}}</div>
                <div class="font-alt mb-40 titan-title-size-4">{{$item['second_title']}}</div>
              </div>
            </div>
          </li>
          @endforeach

        </ul>
      </div>
    </section>
    <div class="main">
        @if(!empty($quote))
      <section class="module" id="about">
        <div class="container">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
              <h2 class="module-title font-alt">{{$quote['title']}}</h2>
              <div class="module-subtitle font-serif large-text">{{$quote['prologue']}}</div>
            </div>
          </div>

        </div>
      </section>
      @endif
      <hr class="divider-w">
      @if(!empty($top_banner['youtube_video']))

      <section class="module bg-dark-60" data-background="https://img.youtube.com/vi/{{$top_banner['youtube_video']}}/hqdefault.jpg">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="video-box">
                <div class="video-box-icon"><a class="video-pop-up" href="https://www.youtube.com/watch?v={{$top_banner['youtube_video']}}"><span class="icon-video"></span></a></div>
                <div class="video-title font-alt">{{__('front.presentation')}}</div>
                <div class="video-subtitle font-alt"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      @endif
      <section class="module pb-0" id="works">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
              <h2 class="module-title font-alt">{{__('front.my_books')}}</h2>
              <div class="module-subtitle font-serif"></div>
            </div>
          </div>
        </div>

        <ul class="works-grid works-grid-gut works-grid-3 works-hover-w" id="works-grid">
          <li class="work-item illustration webdesign"><a href="portfolio-single-1.html">
              <div class="work-image"><img src="assets/images/work-1.jpg" alt="Portfolio Item"/></div>
              <div class="work-caption font-alt">
                <h3 class="work-title">Corporate Identity</h3>
                <div class="work-descr">Illustration</div>
              </div></a></li>
          <li class="work-item marketing photography"><a href="portfolio-single-1.html">
              <div class="work-image"><img src="assets/images/work-2.jpg" alt="Portfolio Item"/></div>
              <div class="work-caption font-alt">
                <h3 class="work-title">Bag MockUp</h3>
                <div class="work-descr">Marketing</div>
              </div></a></li>
          <li class="work-item illustration photography"><a href="portfolio-single-1.html">
              <div class="work-image"><img src="assets/images/work-3.jpg" alt="Portfolio Item"/></div>
              <div class="work-caption font-alt">
                <h3 class="work-title">Disk Cover</h3>
                <div class="work-descr">Illustration</div>
              </div></a></li>
          <li class="work-item marketing photography"><a href="portfolio-single-1.html">
              <div class="work-image"><img src="assets/images/work-4.jpg" alt="Portfolio Item"/></div>
              <div class="work-caption font-alt">
                <h3 class="work-title">Business Card</h3>
                <div class="work-descr">Photography</div>
              </div></a></li>
          <li class="work-item illustration webdesign"><a href="portfolio-single-1.html">
              <div class="work-image"><img src="assets/images/work-5.jpg" alt="Portfolio Item"/></div>
              <div class="work-caption font-alt">
                <h3 class="work-title">Business Card</h3>
                <div class="work-descr">Webdesign</div>
              </div></a></li>
          <li class="work-item marketing webdesign"><a href="portfolio-single-1.html">
              <div class="work-image"><img src="assets/images/work-6.jpg" alt="Portfolio Item"/></div>
              <div class="work-caption font-alt">
                <h3 class="work-title">Business Cards in paper clip</h3>
                <div class="work-descr">Marketing</div>
              </div></a></li>
        </ul>
      </section>


      <hr class="divider-w">

      <section class="module bg-dark-60 pt-0 pb-0 parallax-bg testimonial" >
        <div class="testimonials-slider pt-140 pb-140">
          <ul class="slides">
            <li data-background="assets/images/testimonial_bg.jpg">
              <div class="container">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="module-icon"><span class="icon-quote"></span></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-8 col-sm-offset-2">
                    <blockquote class="testimonial-text font-alt">I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.</blockquote>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                    <div class="testimonial-author">
                      <div class="testimonial-caption font-alt">
                        <div class="testimonial-title">Jack Woods</div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="container">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="module-icon"><span class="icon-quote"></span></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-8 col-sm-offset-2">
                    <blockquote class="testimonial-text font-alt">I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist than now.</blockquote>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                    <div class="testimonial-author">
                      <div class="testimonial-caption font-alt">
                        <div class="testimonial-title">Jim Stone</div>
                        <div class="testimonial-descr">SomeCompany INC, CEO</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div class="container">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="module-icon"><span class="icon-quote"></span></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-8 col-sm-offset-2">
                    <blockquote class="testimonial-text font-alt">I am so happy, my dear friend, so absorbed in the exquisite sense of mere tranquil existence, that I neglect my talents.</blockquote>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4 col-sm-offset-4">
                    <div class="testimonial-author">
                      <div class="testimonial-caption font-alt">
                        <div class="testimonial-title">Adele Snow</div>
                        <div class="testimonial-descr">SomeCompany INC, CEO</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </section>
      <section class="module" id="news">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
              <h2 class="module-title font-alt">Latest blog posts</h2>
              <div class="module-subtitle font-serif">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</div>
            </div>
          </div>
          <div class="row multi-columns-row post-columns">
            <div class="col-sm-6 col-md-4 col-lg-4">
              <div class="post mb-20">
                <div class="post-thumbnail"><a href="#"><img src="assets/images/post-1.jpg" alt="Blog-post Thumbnail"/></a></div>
                <div class="post-header font-alt">
                  <h2 class="post-title"><a href="#">Our trip to the Alps</a></h2>
                  <div class="post-meta">By&nbsp;<a href="#">Mark Stone</a>&nbsp;| 23 November | 3 Comments
                  </div>
                </div>
                <div class="post-entry">
                  <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                </div>
                <div class="post-more"><a class="more-link" href="#">Read more</a></div>
              </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-4">
              <div class="post mb-20">
                <div class="post-thumbnail"><a href="#"><img src="assets/images/post-2.jpg" alt="Blog-post Thumbnail"/></a></div>
                <div class="post-header font-alt">
                  <h2 class="post-title"><a href="#">Shore after the tide</a></h2>
                  <div class="post-meta">By&nbsp;<a href="#">Andy River</a>&nbsp;| 11 November | 4 Comments
                  </div>
                </div>
                <div class="post-entry">
                  <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                </div>
                <div class="post-more"><a class="more-link" href="#">Read more</a></div>
              </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-4">
              <div class="post mb-20">
                <div class="post-thumbnail"><a href="#"><img src="assets/images/post-3.jpg" alt="Blog-post Thumbnail"/></a></div>
                <div class="post-header font-alt">
                  <h2 class="post-title"><a href="#">We in New Zealand</a></h2>
                  <div class="post-meta">By&nbsp;<a href="#">Dylan Woods</a>&nbsp;| 5 November | 15 Comments
                  </div>
                </div>
                <div class="post-entry">
                  <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                </div>
                <div class="post-more"><a class="more-link" href="#">Read more</a></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="module-small bg-dark">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-4 col-lg-offset-2">
              <div class="callout-text font-alt">
                <h3 class="callout-title">Subscribe now</h3>
                <p>We will not spam your email.</p>
              </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4">
              <div class="callout-btn-box">
                <form id="subscription-form" role="form" method="post" action="php/subscribe.php">
                  <div class="input-group">
                    <input class="form-control" type="email" id="semail" name="semail" placeholder="Your Email" data-validation-required-message="Please enter your email address." required="required"/><span class="input-group-btn">
                      <button class="btn btn-g btn-round" id="subscription-form-submit" type="submit">Submit</button></span>
                  </div>
                </form>
                <div class="text-center" id="subscription-response"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <section class="module" id="contact">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
              <h2 class="module-title font-alt">Get in touch</h2>
              <div class="module-subtitle font-serif"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
              <form id="contactForm" role="form" method="post" action="php/contact.php">
                <div class="form-group">
                  <label class="sr-only" for="name">Name</label>
                  <input class="form-control" type="text" id="name" name="name" placeholder="Your Name*" required="required" data-validation-required-message="Please enter your name."/>
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                  <label class="sr-only" for="email">Email</label>
                  <input class="form-control" type="email" id="email" name="email" placeholder="Your Email*" required="required" data-validation-required-message="Please enter your email address."/>
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                  <textarea class="form-control" rows="7" id="message" name="message" placeholder="Your Message*" required="required" data-validation-required-message="Please enter your message."></textarea>
                  <p class="help-block text-danger"></p>
                </div>
                <div class="text-center">
                  <button class="btn btn-block btn-round btn-d" id="cfsubmit" type="submit">Submit</button>
                </div>
              </form>
              <div class="ajax-response font-alt" id="contactFormResponse"></div>
            </div>
          </div>
        </div>
      </section>
      <div class="module-small bg-dark">
        <div class="container">
          <div class="row">
            <div class="col-sm-3">
              <div class="widget">
                <h5 class="widget-title font-alt">About Titan</h5>
                <p>The languages only differ in their grammar, their pronunciation and their most common words.</p>
                <p>Phone: +1 234 567 89 10</p>Fax: +1 234 567 89 10
                <p>Email:<a href="#">somecompany@example.com</a></p>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="widget">
                <h5 class="widget-title font-alt">Recent Comments</h5>
                <ul class="icon-list">
                  <li>Maria on <a href="#">Designer Desk Essentials</a></li>
                  <li>John on <a href="#">Realistic Business Card Mockup</a></li>
                  <li>Andy on <a href="#">Eco bag Mockup</a></li>
                  <li>Jack on <a href="#">Bottle Mockup</a></li>
                  <li>Mark on <a href="#">Our trip to the Alps</a></li>
                </ul>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="widget">
                <h5 class="widget-title font-alt">Blog Categories</h5>
                <ul class="icon-list">
                  <li><a href="#">Photography - 7</a></li>
                  <li><a href="#">Web Design - 3</a></li>
                  <li><a href="#">Illustration - 12</a></li>
                  <li><a href="#">Marketing - 1</a></li>
                  <li><a href="#">Wordpress - 16</a></li>
                </ul>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="widget">
                <h5 class="widget-title font-alt">Popular Posts</h5>
                <ul class="widget-posts">
                  <li class="clearfix">
                    <div class="widget-posts-image"><a href="#"><img src="assets/images/rp-1.jpg" alt="Post Thumbnail"/></a></div>
                    <div class="widget-posts-body">
                      <div class="widget-posts-title"><a href="#">Designer Desk Essentials</a></div>
                      <div class="widget-posts-meta">23 january</div>
                    </div>
                  </li>
                  <li class="clearfix">
                    <div class="widget-posts-image"><a href="#"><img src="assets/images/rp-2.jpg" alt="Post Thumbnail"/></a></div>
                    <div class="widget-posts-body">
                      <div class="widget-posts-title"><a href="#">Realistic Business Card Mockup</a></div>
                      <div class="widget-posts-meta">15 February</div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr class="divider-d">
      <footer class="footer bg-dark">
        <div class="container">
          <div class="row">
            <div class="col-sm-6">
              <p class="copyright font-alt">&copy; 2017&nbsp;<a href="index.html">TitaN</a>, All Rights Reserved</p>
            </div>
            <div class="col-sm-6">
              <div class="footer-social-links"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a><a href="#"><i class="fa fa-skype"></i></a>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>

@endsection
