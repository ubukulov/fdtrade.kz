<!-- bestseller_section - start
			================================================== -->
<section class="bestseller_section sec_ptb_50 pb-0 clearfix">
    <div class="container maxw_1460">

        <div class="row mb_50 align-items-center justify-content-lg-between">
            <div class="col-lg-5">
                <div class="supermarket_section_title clearfix">
                    <span class="sub_title text-uppercase">Широкий выбор товаров</span>
                    <h2 class="title_text mb-0">Бестселлеры</h2>
                </div>
            </div>

            <div class="col-lg-7">
                <ul class="supermarket_tab_nav ul_li_right nav clearfix" role="tablist">
                    <li>
                        <a class="active" data-toggle="tab" href="#top_tab">Top 20</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#phones_tablets_tab">Телефоны и планшеты</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#laptops_computers_tab">Ноутбуки и компьютеры</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#video_cameras_tab">Видеокамеры</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content">
            <div id="top_tab" class="tab-pane active">
                <ul class="supermarket_product_columns has_3columns ul_li bg_white clearfix">
                    @foreach($bestsellerProducts as $bestProduct)
                    <li>
                        <div class="supermarket_product_listlayout">
                            <div class="slideshow1_slider item_image" data-slick='{"arrows": false}'>
                                @foreach($bestProduct->images as $image)
                                <div class="item">
                                    <img src="{{ $image->path }}" alt="image_not_found">
                                </div>
                                @endforeach
                            </div>
                            <div class="item_content">
                                <span class="item_type text-uppercase" data-bg-color="#0062bd">Watch</span>
                                <div class="rating_star_wrap d-flex align-items-center clearfix">
                                    <ul class="rating_star ul_li mr-2 clearfix">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                    </ul>
                                    <span class="rating_value">4.0</span>
                                </div>
                                <h3 class="item_title">
                                    <a href="#!">{{ $bestProduct->name }}</a>
                                </h3>
                                <ul class="product_action_btns ul_li clearfix">
                                    <li><a class="addtocart_btn tooltips" data-placement="top" title="Add To Cart" href="#!">Купить</a></li>
                                    <li><a class="tooltips" data-placement="top" title="Add To Wishlist" href="#!"><i class="fal fa-heart"></i></a></li>
                                </ul>
                                <ul class="info_list ul_li_block clearfix">
                                    <li>
                                        <div class="item_icon">
                                            <i class="fal fa-calendar-alt"></i>
                                        </div>
                                        <div class="item_content">
                                            <p class="mb-0">
                                                Срок доставки: 2 дня
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item_icon">
                                            <i class="fal fa-truck-moving"></i>
                                        </div>
                                        <div class="item_content">
                                            <p class="mb-0">
                                                Общий: 23 заказов
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div id="phones_tablets_tab" class="tab-pane fade">
                <ul class="supermarket_product_columns has_3columns ul_li bg_white clearfix">
                    @foreach($bestsellerProducts as $bestProduct)
                    <li>
                        <div class="supermarket_product_listlayout">
                            <div class="slideshow1_slider item_image" data-slick='{"arrows": false}'>
                                @foreach($bestProduct->images as $image)
                                    <div class="item">
                                        <img src="{{ $image->path }}" alt="image_not_found">
                                    </div>
                                @endforeach
                            </div>
                            <div class="item_content">
                                <span class="item_type text-uppercase" data-bg-color="#0062bd">Watch</span>
                                <div class="rating_star_wrap d-flex align-items-center clearfix">
                                    <ul class="rating_star ul_li mr-2 clearfix">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                    </ul>
                                    <span class="rating_value">4.0</span>
                                </div>
                                <h3 class="item_title">
                                    <a href="#!">{{ $bestProduct->name }}</a>
                                </h3>
                                <ul class="product_action_btns ul_li clearfix">
                                    <li><a class="addtocart_btn tooltips" data-placement="top" title="Add To Cart" href="#!">Купить</a></li>
                                    <li><a class="tooltips" data-placement="top" title="Add To Wishlist" href="#!"><i class="fal fa-heart"></i></a></li>
                                </ul>
                                <ul class="info_list ul_li_block clearfix">
                                    <li>
                                        <div class="item_icon">
                                            <i class="fal fa-calendar-alt"></i>
                                        </div>
                                        <div class="item_content">
                                            <p class="mb-0">
                                                Срок доставки: 2 дня
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item_icon">
                                            <i class="fal fa-truck-moving"></i>
                                        </div>
                                        <div class="item_content">
                                            <p class="mb-0">
                                                Общий: 23 заказов
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    @endforeach

                </ul>
            </div>

            <div id="laptops_computers_tab" class="tab-pane fade">
                <ul class="supermarket_product_columns has_3columns ul_li bg_white clearfix">
                    @foreach($bestsellerProducts as $bestProduct)
                    <li>
                        <div class="supermarket_product_listlayout">
                            <div class="slideshow1_slider item_image" data-slick='{"arrows": false}'>
                                @foreach($bestProduct->images as $image)
                                    <div class="item">
                                        <img src="{{ $image->path }}" alt="image_not_found">
                                    </div>
                                @endforeach
                            </div>
                            <div class="item_content">
                                <span class="item_type text-uppercase" data-bg-color="#0062bd">Watch</span>
                                <div class="rating_star_wrap d-flex align-items-center clearfix">
                                    <ul class="rating_star ul_li mr-2 clearfix">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                    </ul>
                                    <span class="rating_value">4.0</span>
                                </div>
                                <h3 class="item_title">
                                    <a href="#!">{{ $bestProduct->name }}</a>
                                </h3>
                                <ul class="product_action_btns ul_li clearfix">
                                    <li><a class="addtocart_btn tooltips" data-placement="top" title="Add To Cart" href="#!">Купить</a></li>
                                    <li><a class="tooltips" data-placement="top" title="Add To Wishlist" href="#!"><i class="fal fa-heart"></i></a></li>
                                </ul>
                                <ul class="info_list ul_li_block clearfix">
                                    <li>
                                        <div class="item_icon">
                                            <i class="fal fa-calendar-alt"></i>
                                        </div>
                                        <div class="item_content">
                                            <p class="mb-0">
                                                Срок доставки: 2 дня
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item_icon">
                                            <i class="fal fa-truck-moving"></i>
                                        </div>
                                        <div class="item_content">
                                            <p class="mb-0">
                                                Общий: 23 заказов
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endforeach

                </ul>
            </div>

            <div id="video_cameras_tab" class="tab-pane fade">
                <ul class="supermarket_product_columns has_3columns ul_li bg_white clearfix">
                    @foreach($bestsellerProducts as $bestProduct)
                    <li>
                        <div class="supermarket_product_listlayout">
                            <div class="slideshow1_slider item_image" data-slick='{"arrows": false}'>
                                @foreach($bestProduct->images as $image)
                                    <div class="item">
                                        <img src="{{ $image->path }}" alt="image_not_found">
                                    </div>
                                @endforeach
                            </div>
                            <div class="item_content">
                                <span class="item_type text-uppercase" data-bg-color="#0062bd">Watch</span>
                                <div class="rating_star_wrap d-flex align-items-center clearfix">
                                    <ul class="rating_star ul_li mr-2 clearfix">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                    </ul>
                                    <span class="rating_value">4.0</span>
                                </div>
                                <h3 class="item_title">
                                    <a href="#!">{{ $bestProduct->name }}</a>
                                </h3>
                                <ul class="product_action_btns ul_li clearfix">
                                    <li><a class="addtocart_btn tooltips" data-placement="top" title="Add To Cart" href="#!">Купить</a></li>
                                    <li><a class="tooltips" data-placement="top" title="Add To Wishlist" href="#!"><i class="fal fa-heart"></i></a></li>
                                </ul>
                                <ul class="info_list ul_li_block clearfix">
                                    <li>
                                        <div class="item_icon">
                                            <i class="fal fa-calendar-alt"></i>
                                        </div>
                                        <div class="item_content">
                                            <p class="mb-0">
                                                Срок доставки: 2 дня
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item_icon">
                                            <i class="fal fa-truck-moving"></i>
                                        </div>
                                        <div class="item_content">
                                            <p class="mb-0">
                                                Общий: 23 заказов
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</section>
<!-- bestseller_section - end
        ================================================== -->
