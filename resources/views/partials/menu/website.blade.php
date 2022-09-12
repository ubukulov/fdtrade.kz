<!-- slider_section - start
			================================================== -->
<section class="slider_section supermarket_slider sec_ptb_50 clearfix" data-background="assets/images/backgrounds/bg_13.jpg">
    <div class="container maxw_1460">
        <div class="row justify-content-lg-between">
            <div class="col-lg-3">
                <div class="alldepartments_menu_wrap">
                    <div class="alldepartments_dropdown show_lg collapse" id="alldepartments_dropdown">
                        <div class="card">
                            <ul class="alldepartments_menulist ul_li_block clearfix">

                                @foreach($categories as $category)
                                <li class="has_child">
                                    <a href="{{ route('category.show', ['id' => $category->id]) }}">
                                        {{--<span class="icon">
                                            <img src="assets/images/icons/supermarket/icon_04.png" alt="icon_not_found">
                                        </span>--}}
                                        {{ $category->name }}
                                    </a>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="main_slider clearfix" data-slick='{"arrows": false}'>
                    @each('partials.hit_products', $hitProducts, 'hit_product')
                </div>
            </div>

            <div class="col-lg-3">
                @foreach($hitProducts->random(3) as $hitProduct)
                    <div class="sm_offer_item offer_fullimage text-white mb_30">
                        <img style="width: 343px; height: 170px !important;" src="{{ $hitProduct->getThumb() }}" alt="image_not_found">
                        <div class="item_content">
                            <h3 class="item_title text-white">
                                {{ $hitProduct->name }}
                            </h3>
                            <span class="item_price">Цена: {{ $hitProduct->getPriceFormatter() }} ₸</span>
                            <a class="text_btn" href="#!">
                                <span>Pre - Order Now</span>
                                <i class="fal fa-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- slider_section - end
        ================================================== -->
