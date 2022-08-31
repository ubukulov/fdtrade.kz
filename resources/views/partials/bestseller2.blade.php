<!-- bestseller_section - start
			================================================== -->
<section class="bestseller_section sec_ptb_100 clearfix">
    <div class="container">
        <div class="row justify-content-lg-between">

            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="bestseller_wrap">
                    <div class="supermarket_section_title mb_50 clearfix">
                        <h2 class="title_text mb-0">Бестселлеры</h2>
                    </div>

                    @foreach($randomProducts->random(3) as $item)
                    <div class="supermarket_product_small">
                        <div class="item_image">
                            <img style="width: 160px; height: 160px !important;" src="{{ $item->getImage() }}" alt="image_not_found">
                            <ul class="product_label ul_li_block clearfix">
                                <li data-bg-color="#cc1414">-70%</li>
                            </ul>
                        </div>
                        <div class="item_content">
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
                    </div>
                    @endforeach

                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="bestseller_wrap">
                    <div class="supermarket_section_title mb_50 clearfix">
                        <h2 class="title_text mb-0">Хиты продаж</h2>
                    </div>

                    @foreach($randomProducts->random(3) as $item)
                        <div class="supermarket_product_small">
                            <div class="item_image">
                                <img style="width: 160px; height: 160px !important;" src="{{ $item->getImage() }}" alt="image_not_found">
                                <ul class="product_label ul_li_block clearfix">
                                    <li data-bg-color="#cc1414">-70%</li>
                                </ul>
                            </div>
                            <div class="item_content">
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
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="bestseller_wrap">
                    <div class="supermarket_section_title mb_50 clearfix">
                        <h2 class="title_text mb-0">Распродажа</h2>
                    </div>

                    @foreach($randomProducts->random(3) as $item)
                        <div class="supermarket_product_small">
                            <div class="item_image">
                                <img style="width: 160px; height: 160px !important;" src="{{ $item->getImage() }}" alt="image_not_found">
                                <ul class="product_label ul_li_block clearfix">
                                    <li data-bg-color="#cc1414">-70%</li>
                                </ul>
                            </div>
                            <div class="item_content">
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
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>
<!-- bestseller_section - end
        ================================================== -->
