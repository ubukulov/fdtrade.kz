<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Интернет магазин FastDev Trade</title>
    <link rel="shortcut icon" href="assets/images/logo/favourite_icon_01.png">

    <!-- fraimwork - css include -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <!-- icon - css include -->
    <link rel="stylesheet" type="text/css" href="assets/css/fontawesome.css">

    <!-- animation - css include -->
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css">

    <!-- nice select - css include -->
    <link rel="stylesheet" type="text/css" href="assets/css/nice-select.css">

    <!-- carousel - css include -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css">
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css">

    <!-- popup images & videos - css include -->
    <link rel="stylesheet" type="text/css" href="assets/css/magnific-popup.css">

    <!-- jquery ui - css include -->
    <link rel="stylesheet" type="text/css" href="assets/css/jquery-ui.css">

    <!-- custom - css include -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>


<body class="home_supermarket">


<!-- backtotop - start -->
<div id="thetop"></div>
<div class="backtotop bg_supermarket_red">
    <a href="#" class="scroll">
        <i class="far fa-arrow-up"></i>
    </a>
</div>
<!-- backtotop - end -->

<!-- preloader - start -->
<!-- <div id="preloader"></div> -->
<!-- preloader - end -->


<!-- header_section - start
		================================================== -->
<header class="header_section supermarket_header bg-white clearfix">
    {{--<div class="header_top text-white clearfix">
        <div class="container maxw_1460">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-5">
                    <p class="welcome_text mb-0">Welcome to Worldwide Online marketplace Store</p>
                </div>

                <div class="col-lg-7">
                    <ul class="info_list ul_li_right clearfix">
                        <li><a href="#!"><i class="fal fa-map-marker-alt"></i> Store Locator</a></li>
                        <li><a href="#!"><i class="fal fa-truck"></i> Track Your Order</a></li>
                        <li>
                            <form action="#">
                                <div class="currency_select option_select mb-0">
                                    <select>
                                        <option value="USD" selected>US Dollars</option>
                                        <option value="EUR">Euro</option>
                                        <option value="GBP">UK Pounds</option>
                                    </select>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>--}}

    <div class="header_middle clearfix">
        <div class="container maxw_1460">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-3">
                    <div class="brand_logo">
                        <a class="brand_link" href="{{ route('home') }}">
                            <img src="assets/images/logo/logo_18_1x.png" srcset="assets/images/logo/logo_18_2x.png 2x" alt="logo_not_found">
                        </a>

                        <ul class="mh_action_btns ul_li clearfix">
                            <li>
                                <button type="button" class="search_btn" data-toggle="collapse" data-target="#search_body_collapse" aria-expanded="false" aria-controls="search_body_collapse">
                                    <i class="fal fa-search"></i>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="cart_btn">
                                    <i class="fal fa-shopping-cart"></i>
                                    <span class="btn_badge">2</span>
                                </button>
                            </li>
                            <li><button type="button" class="mobile_menu_btn"><i class="far fa-bars"></i></button></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6">
                    <form action="#">
                        <div class="medical_search_bar">
                            <div class="form_item">
                                <input type="search" name="search" placeholder="search here...">
                            </div>

                            <button type="submit" class="submit_btn"><i class="fal fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-3">
                    <div class="supermarket_header_btns clearfix">
                        <ul class="action_btns_group ul_li_right clearfix">
                            <li>
                                <button type="button">
                                    <span>Нужно</span>
                                    <strong>помощь?</strong>
                                </button>
                            </li>
                            <li>
                                <button type="button">
                                    <span>Ваш</span>
                                    <strong>Аккаунт</strong>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="cart_btn">
                                    <i class="fal fa-shopping-bag"></i>
                                    <span class="btn_badge">2</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header_bottom clearfix">
        <div class="container maxw_1460">
            <nav class="main_menu clearfix">
                <ul class="ul_li clearfix">
                    <li>
                        <button class="alldepartments_btn bg_supermarket_red text-uppercase" type="button" data-toggle="collapse" data-target="#alldepartments_dropdown" aria-expanded="false" aria-controls="alldepartments_dropdown">
                            <i class="far fa-bars"></i> Все категории
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div id="search_body_collapse" class="search_body_collapse collapse">
        <div class="search_body">
            <div class="container-fluid prl_90">
                <form action="#">
                    <div class="form_item mb-0">
                        <input type="search" name="search" placeholder="Type here...">
                        <button type="submit"><i class="fal fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
<!-- header_section - end
		================================================== -->


<!-- main body - start
		================================================== -->
<main>
    @yield('content')
</main>
<!-- main body - end
		================================================== -->


<!-- footer_section - start
		================================================== -->
<footer class="footer_section supermarket_footer clearfix">
    <div class="footer_widget_area sec_ptb_100 bg_white clearfix">
        <div class="container">
            <div class="row justify-content-lg-between">

                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="footer_widget footer_useful_links clearfix">
                        <h3 class="footer_widget_title">Покупателям</h3>
                        <ul class="ul_li_block clearfix">
                            <li><a href="#!">Войти</a></li>
                            <li><a href="#!">Защита Покупателя</a></li>
                            <li><a href="#!">Варианты оплаты</a></li>
                            <li><a href="#!">Политика доставки</a></li>
                            <li><a href="#!">Политика возврата</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="footer_widget bestrated_products">
                        <h3 class="footer_widget_title">Продукты с лучшим рейтингом</h3>

                        @foreach($randomProducts->random(2) as $item)
                        <div class="supermarket_product_small">
                            <h3 class="item_title">
                                <a href="#!">{{ $item->name }}</a>
                            </h3>
                            <span class="item_price">₸ {{ $item->getPriceFormatter() }}</span>
                            <ul class="rating_star ul_li clearfix">
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fal fa-star"></i></li>
                            </ul>
                        </div>
                        @endforeach

                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="footer_widget footer_useful_links clearfix">
                        <h3 class="footer_widget_title">Информация</h3>
                        <ul class="ul_li_block clearfix">
                            <li><a href="#!">О нас</a></li>
                            <li><a href="#!">Группа доверия</a></li>
                            <li><a href="#!">История рынка</a></li>
                            <li><a href="#!">Новости</a></li>
                            <li><a href="#!">Свяжитесь с нами</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="footer_widget supermarket_footer_contact">
                        <h3 class="footer_widget_title">Контакты</h3>
                        <ul class="ul_li_block clearfix">
                            <li>
                                <div class="item_icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="item_content">
                                    <p class="mb-0">
                                        ул. Бегалина 7, кв. 161
                                    </p>
                                </div>
                            </li>
                            <li>
                                <div class="item_icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="item_content">
                                    <p class="mb-0">+7 701 960 1017</p>
                                </div>
                            </li>
                            <li>
                                <div class="item_icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="item_content">
                                    <p class="mb-0">Email: yernur@fastdev.org</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer_middle sec_ptb_50 text-white clearfix" data-bg-color="#23292d">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5 col-md-7 col-sm-9 col-xs-12">
                    <div class="form_item mb-0">
                        <form action="#">
                            <input type="email" name="email" placeholder="Введите Email">
                            <button type="submit" class="submit_btn">Зарегистроваться</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-3 col-md-7 col-sm-9 col-xs-12">
                    <div class="footer_electronic_hotline mb_30">
                        <i class="fal fa-headset"></i>
                        <h4 class="text-white">ЕСТЬ ВОПРОСЫ? ЗВОНИТЕ НАМ 24/7!</h4>
                        <span>+7 701 960 1017</span>
                    </div>
                </div>

                <div class="col-lg-4 col-md-7 col-sm-9 col-xs-12">
                    <ul class="circle_social_links ul_li_right clearfix">
                        <li><a href="#!"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#!"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#!"><i class="fab fa-google-plus-g"></i></a></li>
                        <li><a href="#!"><i class="fab fa-dribbble"></i></a></li>
                        <li><a href="#!"><i class="fab fa-linkedin-in"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer_bottom text-white clearfix" data-bg-color="#191e22">
        <div class="container">
            <div class="row justify-content-lg-between">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <p class="copyright_text mb-0">© <a href="#!" class="author_link text-white">FastDev Trade</a> - All rights Reserved</p>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="payment_methods float-lg-right float-md-right">
                        <img src="assets/images/payment_methods_01.png" alt="image_not_found">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer_section - end
		================================================== -->


<!-- fraimwork - jquery include -->
<script src="assets/js/jquery-3.5.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- mobile menu - jquery include -->
<script src="assets/js/mCustomScrollbar.js"></script>

<!-- animation - jquery include -->
<script src="assets/js/parallaxie.js"></script>
<script src="assets/js/wow.min.js"></script>

<!-- nice select - jquery include -->
<script src="assets/js/nice-select.min.js"></script>

<!-- carousel - jquery include -->
<script src="assets/js/slick.min.js"></script>

<!-- countdown timer - jquery include -->
<script src="assets/js/countdown.js"></script>

<!-- popup images & videos - jquery include -->
<script src="assets/js/magnific-popup.min.js"></script>

<!-- filtering & masonry layout - jquery include -->
<script src="assets/js/isotope.pkgd.min.js"></script>
<script src="assets/js/masonry.pkgd.min.js"></script>
<script src="assets/js/imagesloaded.pkgd.min.js"></script>

<!-- jquery ui - jquery include -->
<script src="assets/js/jquery-ui.js"></script>

<!-- custom - jquery include -->
<script src="assets/js/custom.js"></script>


</body>
</html>
