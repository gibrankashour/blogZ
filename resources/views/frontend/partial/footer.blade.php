<!-- Footer Area -->
<footer id="wn__footer" class="footer__area bg__cat--8 brown--color">
    <div class="footer-static-top py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__widget footer__menu">
                        <div class="ft__logo">
                            <a href="{{route('home')}}">
                                <img src={{asset("frontend/images/logo/3.png")}} alt="logo">
                            </a>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered duskam alteration variations of passages</p>
                        </div>
                        <div class="footer__content">
                            <ul class="social__net social__net--2 d-flex justify-content-center">
                                <li><a href="#"><i class="bi bi-facebook"></i></a></li>                                
                                <li><a href="#"><i class="bi bi-twitter"></i></a></li>
                                <li><a href="#"><i class="bi bi-linkedin"></i></a></li>
                                <li><a href="#"><i class="bi bi-youtube"></i></a></li>
                            </ul>
                            <ul class="mainmenu d-flex justify-content-center">
                                <li><a href="{{route('home')}}">Home</a></li>
                                <li><a href="{{route('categories')}}">Categories</a></li>
                                <li><a href="{{route('page', 'about_us')}}">About us</a></li>
                                <li><a href="{{route('page', 'our_vision')}}">Our vision</a></li>
                                <li><a href="{{route('contact')}}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright__wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="copyright">
                        <div class="copy__right__inner text-center">
                            <p>Copyright <i class="fa fa-copyright"></i> {{env('APP_NAME', 'Laravel')}} All Rights Reserved</p>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</footer>
<!-- //Footer Area -->