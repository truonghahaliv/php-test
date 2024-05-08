<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{('assets/css/all.min.css')}}">
    <link rel="stylesheet" href="{{('assets/css/style.css')}}">
    <title>Document</title>
</head>
<body>
<!-- === HEADER === -->
<header class="l-header">
    <nav class="nav bg-grid">
        <div>
            <a href="#" class="nav-logo">SARA</a>
        </div>

        <div class="nav-menu" id="nav-menu">
            <ul class="nav-list">


                <li class="nav-item"><a href="/" class="nav-link active">Home</a></li>
                @if (Route::has('login'))
                    <nav class="-mx-3 flex flex-1 justify-end">
                        @auth
                            @if(auth()->check() && auth()->user()->roles->contains('name', 'admin'))
                                <a href="{{ url('/dashboard') }}" style="margin-left: 30px">Admin</a>
                            @endif




                            <x-dropdown-link :href="route('profile.edit')" style="margin-left: 30px">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                                                                        this.closest('form').submit();"
                                                 style="margin-left: 30px">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>

                        @else
                            <a style="margin-left: 30px"
                               href="{{ route('login') }}"
                               class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a style="margin-left: 30px"
                                   href="{{ route('register') }}"
                                   class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
            @endif


        </div>

    </nav>

</header>

<!-- === MAIN PAGE === -->
<main class="l-main">
    <!-- === HOME === -->
    <section id="home" class="home">
        <div class="home-container bg-grid">
            <div class="home-data">
                <h1 class="home-title">NEW <br><span>ARRIVALS</span></h1>

            </div>
            <img src="/assets/images/home.png" alt="homepage" class="home-img">
        </div>
    </section>
    <!-- === collection === -->
    <section class="collection section">
        <div class="collection-container bg-grid">
            <div class="collection-box">
                <img src="/assets/images/backpackMan.png" alt="packpackman" class="collection-img">
                <div class="collection-data">
                    <h2 class="collection-title"><span class="subtitle">Men</span><br> Backpack</h2>
                    <a href="#" class="view-collection">View Collection</a>
                </div>
            </div>
            <div class="collection-box">
                <div class="collection-data">
                    <h2 class="collection-title"><span class="subtitle">Women</span><br> Backpack</h2>
                    <a href="#" class="view-collection">View Collection</a>
                </div>
                <img src="/assets/images/backpackWoman.png" alt="packpackman" class="collection-img">
            </div>
        </div>
    </section>
    <!-- === features === -->
    <section class="featured section" id="featured">
        <h2 class="section-title">featured products</h2>
        <a href="#" class="section-all">View All</a>
        <div class="featured-container bg-grid">
            @foreach ($products as $p)
                <div class="featured-product">
                    <div class="featured-box" style="width: 150px;height:180px">
                        <div class="featured-new">New</div>
                        <img src="{{asset($p -> image) }}" style=" width: 150px; height: 180px; " alt="featured"
                             class="featured-img">
                    </div>
                    <div class="featured-data">
                        <h3 class="product-name">{{$p-> name}}</h3>
                        <span class="product-price">${{$p ->price}}</span>
                    </div>
                </div>
            @endforeach


        </div>
        <div class="pagination"> {{$products->links()}}</div>
    </section>
    <!-- === OFFERS === -->
    <section class="offer section">
        <div class="offer-bg">
            <div class="offer-data">
                <h2 class="offer-title">special offers</h2>
                <p class="offer-decripition">special offers discounte for Women this week only.</p>
                <a href="#" class="btn">SHOP NOW</a>
            </div>
        </div>
    </section>
    <!-- === NEW === -->
    <section class="section new" id="new">
        <h2 class="section-title">NEW ARRIVALS</h2>
        <a href="#new" class="section-all">view all</a>
        <div class="new-container bg-grid">
            <div class="new-box">
                <img src="/assets/images/new1.png" alt="new" class="new-img">
                <div class="new-link">
                    <a href="#" class="btn">VIEW PRODUCT</a>
                </div>
            </div>
            <div class="new-box">
                <img src="/assets/images/new2.png" alt="new" class="new-img">
                <div class="new-link">
                    <a href="#" class="btn">VIEW PRODUCT</a>
                </div>
            </div>
            <div class="new-box">
                <img src="/assets/images/new3.png" alt="new" class="new-img">
                <div class="new-link">
                    <a href="#" class="btn">VIEW PRODUCT</a>
                </div>
            </div>
            <div class="new-box">
                <img src="/assets/images/new4.png" alt="new" class="new-img">
                <div class="new-link">
                    <a href="#" class="btn">VIEW PRODUCT</a>
                </div>
            </div>
            <div class="new-box">
                <img src="/assets/images/new5.png" alt="new" class="new-img">
                <div class="new-link">
                    <a href="#" class="btn">VIEW PRODUCT</a>
                </div>
            </div>
            <div class="new-box">
                <img src="/assets/images/new6.png" alt="new" class="new-img">
                <div class="new-link">
                    <a href="#" class="btn">VIEW PRODUCT</a>
                </div>
            </div>
        </div>
    </section>
    <!-- === NEWLETTER === -->
    <section class="section newsletter" id="subscribed">
        <div class="newsletter-container bg-grid">
            <div class="newsletter-subscribe">
                <h2 class="section-title">OUR NEWLETTER</h2>
                <p class="newsletter-decs">pormotion new products and sales. Directly to you</p>
                <form action="" class="newsletter-form">
                    <input type="text" class="newsletter-input" placeholder="Enter Your Email">
                    <a href="#" class="btn">SUBSCRIBE</a>
                </form>
            </div>
        </div>
    </section>
    <!-- === SPONSORS === -->
    <section class="section sponsors">
        <div class="sponsors-container bg-grid">
            <div class="sponsors-logo">
                <img src="/assets/images/logo1.png" alt="sponsors">
            </div>
            <div class="sponsors-logo">
                <img src="/assets/images/logo2.png" alt="sponsors">
            </div>
            <div class="sponsors-logo">
                <img src="/assets/images/logo3.png" alt="sponsors">
            </div>
            <div class="sponsors-logo">
                <img src="/assets/images/logo4.png" alt="sponsors">
            </div>
        </div>
    </section>
    <!-- === FOOTER === -->
    <section class="section footer">
        <div class="footer-container bg-grid">
            <div class="footer-box">
                <h3 class="footer-title">SARA</h3>
                <p class="footer-decs">products store</p>
                <a href="#" class="footer-store"><img src="/assets/images/footerstore1.png" alt="store"></a>
                <a href="#" class="footer-store"><img src="/assets/images/footerstore2.png" alt="store"></a>

            </div>
            <div class="footer-box">
                <h3 class="footer-title">Explore</h3>
                <ul>
                    <li><a href="#home" class="footer-link">Home</a></li>
                    <li><a href="#featured" class="footer-link">Featured</a></li>
                    <li><a href="#new" class="footer-link">New</a></li>
                    <li><a href="#subscribe" class="footer-link">Subscribe</a></li>
                </ul>
            </div>
            <div class="footer-box">
                <h3 class="footer-title">Our Services</h3>
                <ul>
                    <li><a href="#home" class="footer-link">pricing</a></li>
                    <li><a href="#featured" class="footer-link">free shipping</a></li>
                    <li><a href="#new" class="footer-link">gift card</a></li>
                </ul>
            </div>
            <div class="footer-box">
                <h3 class="footer-title">Explore</h3>
                <ul class="social-icons">
                    <li><a href="#" class="footer-link "><i class="fab fa-facebook-square"></i></a></li>
                    <li><a href="#" class="footer-link"><i class="fab fa-instagram-square"></i></a></li>
                    <li><a href="#" class="footer-link"><i class="fab fa-twitter-square "></i></a></li>

                </ul>
            </div>
        </div>
        <p class="footer-copy">&#169; 2024 Copyright all right reserved</p>
    </section>
</main>
<script src="{{('assets/js/main.js')}}"></script>
</body>
</html>
