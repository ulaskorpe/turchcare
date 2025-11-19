<div id="main-menu" data-scroll-to-active="true" class="main-menu menu-dark menu-fixed menu-shadow menu-accordion">

    <!-- main menu content-->
    <div class="main-menu-content">
      <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">

        @if( $data['role']['name']  == 'sudo')
        <li class=" nav-item"><a href="{{route('dashboard')}}">

            <i class="icon-key22"></i><span data-i18n="nav.dash.main"  class="menu-title">SUDO Panel </span><span class="tag hidden tag tag-danger tag-pill float-xs-right mr-2">5</span></a>
            <ul class="menu-content">
              <li @if(isset($type) && $type->active =='sudo') class="active" @endif><a href="{{route('sudo.types.index')}}" class="menu-item">Content Types </a></li>
              <li><a href="#" class="menu-item">Admins </a></li>
              <li><a href="#" class="menu-item">Roles </a></li>

            </ul>
          </li>
        @endif

        <li class=" nav-item"><a href="{{route('dashboard')}}">

            <i class="icon-info"></i><span data-i18n="nav.dash.main"  class="menu-title">Site Bilgileri </span><span class="tag hidden tag tag-danger tag-pill float-xs-right mr-2">5</span></a>



            <ul class="menu-content">

              <li @if(isset($type) && $type->active =='info') class="active" @endif><a href="{{route('content-list','top_banner')}}" class="menu-item">Site Başlığı </a></li>


             <li><a href="{{route('content-list','site_phone')}}" class="menu-item">Telefon + Adres </a></li>
              <li><a href="{{route('content-list','keywords')}}" class="menu-item">Anahtar Kelimeler  </a></li>
              <li><a href="{{route('content-list','description')}}" class="menu-item">Description </a></li>
              <li><a href="{{route('content-list','seo_title')}}" class="menu-item">SEO Title </a></li>
              <li><a href="{{route('content-list','seo_description')}}" class="menu-item">SEO Description </a></li>
              <li><a href="{{route('content-list','seo_keywords')}}" class="menu-item">SEO Keywords </a></li>
              <li><a href="{{route('content-list','seo_keywords')}}" class="menu-item">Sosyal Medya Linkleri </a></li>

            </ul>
          </li>
        <li class=" nav-item"><a href="{{route('dashboard')}}">

          <i class="icon-home3"></i><span data-i18n="nav.dash.main"  class="menu-title">AnaSayfa </span><span class="tag hidden tag tag-danger tag-pill float-xs-right mr-2">5</span></a>



          <ul class="menu-content">



            <li  @if(isset($type) && $type->active =='home') class="active" @endif><a href="{{route('content-list','slider')}}" class="menu-item">Slider  </a></li>

            <li><a href="{{route('content-list','seo_title')}}" class="menu-item">Choose Us Spot  </a></li>
            <li><a href="{{route('content-list','seo_title')}}" class="menu-item">Choose Us Items  </a></li>

          </ul>
        </li>
        <li class=" nav-item"><a href="{{route('admin-messages')}}"><i class="icon-envelope"></i><span data-i18n="nav.changelog.main" class="menu-title">Mesajlar</span>

        <li class=" nav-item"><a href="#"><i class="icon-pencil-square-o"></i><span data-i18n="nav.dash.treat"  class="menu-title">Hakkımda</span></a>
            <ul class="menu-content">
              <li  @if(isset($type) && $type->active =='about_us') class="active" @endif><a href="{{route('content-list','about_us')}}" class="menu-item">Hakkımızda Metin</a>
              </li>
              <li  @if(isset($type) && $type->active =='about_us_slider') class="active" @endif><a href="{{route('content-list','about_us_slider')}}" class="menu-item">Hakkımızda Slider</a>
              </li>
            </ul>
          </li>
          <li class=" nav-item"><a href="#"><i class="icon-pencil-square-o"></i><span data-i18n="nav.dash.treat"  class="menu-title">Galeriler</span></a>
            <ul class="menu-content">



              <li  @if(isset($type) && $type->active =='gallery') class="active" @endif><a href="{{route('content-list','categories')}}" class="menu-item">Galeriler</a>
              </li>
              <li><a href="{{route('content-list','gallery_item')}}" class="menu-item">Resimler</a>
              </li>
              <li><a href="{{route('content-list','videos')}}" class="menu-item">Videolar</a>
              </li>
            </ul>
          </li>
          <li class=" nav-item"><a href="#"><i class="icon-medical-case"></i><span data-i18n="nav.dash.treatments" class="menu-title">Tedaviler</span></a>
            <ul class="menu-content">
              <li @if(isset($type) && $type->active =='treatments') class="active" @endif><a href="{{route('content-list','treatments')}}" class="menu-item">Tedavi Listesi</a></li>
              <li @if(isset($type) && $type->active =='treatment_categories') class="active" @endif><a href="{{route('content-list','treatment_categories')}}" class="menu-item">Tedavi Kategorileri</a></li>
            </ul>
          </li>








        <li class=" nav-item"><a href="#"><i class="icon-pencil-square-o"></i><span data-i18n="nav.dash.blog" class="menu-title">Bloglar</span></a>
          <ul class="menu-content">


                <li  @if(isset($type) && $type->active == 'blogs' ) class="active" @endif ><a href="{{route('admin-comments')}}">Yorumlar</a></span>
                <li ><a href="{{route('content-list','blogs')}}" class="menu-item">Blog Liste</a></li>
           <!--     <li ><a href="{{route('content-list','tags')}}" class="menu-item">Blog Etiketler</a></li>-->
          </ul>
        </li>









        <!--    <span class="tag tag tag-pill tag-danger float-xs-right">100</span>-->
        </a>
        </li>



      </ul>
    </div>
    <!-- /main menu content-->
    <!-- main menu footer-->
    <div class="main-menu-footer footer-close">
      <div class="header text-xs-center"><a href="#" class="col-xs-12 footer-toggle"><i class="icon-ios-arrow-up"></i></a></div>
      <div class="content">
        <div class="insights">
          <div class="col-xs-12">
            <p>Product Delivery</p>
            <progress value="25" max="100" class="progress progress-xs progress-success">25%</progress>
          </div>
          <div class="col-xs-12">
            <p>Targeted Sales</p>
            <progress value="70" max="100" class="progress progress-xs progress-info">70%</progress>
          </div>
        </div>
        <div class="actions"><a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Settings"><span aria-hidden="true" class="icon-cog3"></span></a><a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock"><span aria-hidden="true" class="icon-lock4"></span></a><a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Logout"><span aria-hidden="true" class="icon-power3"></span></a></div>
      </div>
    </div>
    <!-- main menu footer-->
  </div>
