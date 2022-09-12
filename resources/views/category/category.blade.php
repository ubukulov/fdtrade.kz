@extends('layouts.app')
@section('content')
    <div class="product_section sec_ptb_100 clearfix">
        <div class="container">
            <div class="row">

                <div class="col-lg-9 order-last">
                    <div class="carparts_filetr_bar clearfix" style="display: none">
                        <div class="row align-items-center justify-content-lg-between">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <ul class="carparts_layout_btns nav ul_li" role="tablist">
                                    <li>
                                        <a class="active" data-toggle="tab" href="#grid_layout"><i class="fas fa-th"></i></a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#list_layout"><i class="fas fa-list"></i></a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <h4 class="result_text text-center">Showing 1 to 10 of 243 products</h4>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <form action="#">
                                    <div class="option_select d-flex align-items-center mb-0">
                                        <span class="option_title text-uppercase">Sort by:</span>
                                        <select style="display: none;">
                                            <option data-display="Select Your Option">Nothing</option>
                                            <option value="1" selected=""> Popularity</option>
                                            <option value="2">Another option</option>
                                            <option value="3" disabled="">A disabled option</option>
                                            <option value="4">Potato</option>
                                        </select><div class="nice-select" tabindex="0"><span class="current"> Popularity</span><ul class="list"><li data-value="Nothing" data-display="Select Your Option" class="option">Nothing</li><li data-value="1" class="option selected"> Popularity</li><li data-value="2" class="option">Another option</li><li data-value="3" class="option disabled">A disabled option</li><li data-value="4" class="option">Potato</li></ul></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div id="grid_layout" class="tab-pane active">
                            <div class="row mb_50">

                                @foreach($products as $product)
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                    <div class="carparts_product_grid" data-bg-color="#f0eeee" style="background: rgb(240, 238, 238);">
                                        <div class="item_image" data-bg-color="#f8f8f8" style="background: rgb(248, 248, 248);">
                                            <img @if($product->category_id > 566) src="/uploads/products/{{ $product->getImage() }}" @else src="{{ $product->getThumb() }}" @endif alt="image_not_found">
                                            {{--<ul class="product_action_btns ul_li_center clearfix">
                                                <li><a class="tooltips" data-placement="top" title="Add To Wishlist" href="#!"><i class="fal fa-heart"></i></a></li>
                                                <li><a class="tooltips" data-placement="top" title="Add To Cart" href="#!"><i class="fal fa-shopping-basket"></i></a></li>
                                                <li><a class="tooltips" data-placement="top" title="Quick View" href="#!" data-toggle="modal" data-target="#quickview_modal"><i class="fal fa-search"></i></a></li>
                                            </ul>--}}
                                        </div>
                                        <div class="item_content">
                                            <ul class="rating_star ul_li clearfix">
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fal fa-star"></i></li>
                                            </ul>
                                            <h3 class="item_title">
                                                <a href="{{ route('product.detail', ['id' => $categoryId, 'productId' => $product->id]) }}">{{ $product->name }}</a>
                                            </h3>
                                            <span class="price_text"><strong>₸ {{ $product->getPriceFormatter() }}</strong></span>
                                        </div>
                                        {{--<ul class="product_label ul_li text-uppercase clearfix">
                                            <li class="bg_carparts_red">New</li>
                                            <li class="bg_carparts_red">Sale</li>
                                        </ul>--}}
                                    </div>
                                </div>
                                @endforeach

                            </div>

                            <div class="carparts_pagination_wrap clearfix">
                                <div class="row align-items-center justify-content-lg-between">
                                    {!! $products->links() !!}
                                    {{--<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <button type="button" class="custom_btn bg_carparts_red text-uppercase"><i class="fas fa-arrow-circle-down mr-2"></i> Load More</button>
                                    </div>

                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <ul class="carparts_pagination_nav ul_li_right clearfix">
                                            <li class="active"><a href="#!">1</a></li>
                                            <li><a href="#!">2</a></li>
                                            <li><a href="#!">3</a></li>
                                            <li><a href="#!">...</a></li>
                                            <li><a href="#!">4</a></li>
                                            <li><a href="#!">5</a></li>
                                            <li><a href="#!">7</a></li>
                                        </ul>
                                    </div>--}}
                                </div>
                            </div>
                        </div>

                        <div id="list_layout" class="tab-pane fade">
                            <div class="mb_50">
                                <div class="carparts_product_listlayout" data-bg-color="#f0eeee" style="background: rgb(240, 238, 238);">
                                    <div class="item_image" data-bg-color="#f8f8f8" style="background: rgb(248, 248, 248);">
                                        <img src="assets/images/shop/car_parts/img_01.png" alt="image_not_found">
                                        <ul class="product_label ul_li text-uppercase clearfix">
                                            <li class="bg_carparts_red">New</li>
                                            <li class="bg_carparts_red">Sale</li>
                                        </ul>
                                    </div>
                                    <div class="item_content">
                                        <ul class="rating_star ul_li clearfix">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fal fa-star"></i></li>
                                        </ul>
                                        <h3 class="item_title text-uppercase">
                                            <a href="#!">earphone case</a>
                                        </h3>
                                        <p class="mb-0">
                                            Praesent quis vestibulum risus. Suspendisse non malesuada risus, ut venenatis nisi. Quisque aliquam justo in est tempor malesuada ac eu sem.
                                        </p>
                                        <div class="action_btns_wrap">
                                            <span class="price_text"><strong>$29.90</strong> <del>$48.90</del></span>
                                            <ul class="product_action_btns ul_li clearfix">
                                                <li><a class="tooltips" data-placement="top" title="Add To Wishlist" href="#!"><i class="fal fa-heart"></i></a></li>
                                                <li><a class="tooltips" data-placement="top" title="Add To Cart" href="#!"><i class="fal fa-shopping-basket"></i></a></li>
                                                <li><a class="tooltips" data-placement="top" title="Quick View" href="#!" data-toggle="modal" data-target="#quickview_modal"><i class="fal fa-search"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="carparts_product_listlayout" data-bg-color="#f0eeee" style="background: rgb(240, 238, 238);">
                                    <div class="item_image" data-bg-color="#f8f8f8" style="background: rgb(248, 248, 248);">
                                        <img src="assets/images/shop/car_parts/img_02.png" alt="image_not_found">
                                        <ul class="product_label ul_li text-uppercase clearfix">
                                            <li class="bg_carparts_red">New</li>
                                            <li class="bg_carparts_red">Sale</li>
                                        </ul>
                                    </div>
                                    <div class="item_content">
                                        <ul class="rating_star ul_li clearfix">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fal fa-star"></i></li>
                                        </ul>
                                        <h3 class="item_title text-uppercase">
                                            <a href="#!">earphone case</a>
                                        </h3>
                                        <p class="mb-0">
                                            Praesent quis vestibulum risus. Suspendisse non malesuada risus, ut venenatis nisi. Quisque aliquam justo in est tempor malesuada ac eu sem.
                                        </p>
                                        <div class="action_btns_wrap">
                                            <span class="price_text"><strong>$29.90</strong> <del>$48.90</del></span>
                                            <ul class="product_action_btns ul_li clearfix">
                                                <li><a class="tooltips" data-placement="top" title="Add To Wishlist" href="#!"><i class="fal fa-heart"></i></a></li>
                                                <li><a class="tooltips" data-placement="top" title="Add To Cart" href="#!"><i class="fal fa-shopping-basket"></i></a></li>
                                                <li><a class="tooltips" data-placement="top" title="Quick View" href="#!" data-toggle="modal" data-target="#quickview_modal"><i class="fal fa-search"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="carparts_product_listlayout" data-bg-color="#f0eeee" style="background: rgb(240, 238, 238);">
                                    <div class="item_image" data-bg-color="#f8f8f8" style="background: rgb(248, 248, 248);">
                                        <img src="assets/images/shop/car_parts/img_03.png" alt="image_not_found">
                                        <ul class="product_label ul_li text-uppercase clearfix">
                                            <li class="bg_carparts_red">New</li>
                                            <li class="bg_carparts_red">Sale</li>
                                        </ul>
                                    </div>
                                    <div class="item_content">
                                        <ul class="rating_star ul_li clearfix">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fal fa-star"></i></li>
                                        </ul>
                                        <h3 class="item_title text-uppercase">
                                            <a href="#!">earphone case</a>
                                        </h3>
                                        <p class="mb-0">
                                            Praesent quis vestibulum risus. Suspendisse non malesuada risus, ut venenatis nisi. Quisque aliquam justo in est tempor malesuada ac eu sem.
                                        </p>
                                        <div class="action_btns_wrap">
                                            <span class="price_text"><strong>$29.90</strong> <del>$48.90</del></span>
                                            <ul class="product_action_btns ul_li clearfix">
                                                <li><a class="tooltips" data-placement="top" title="Add To Wishlist" href="#!"><i class="fal fa-heart"></i></a></li>
                                                <li><a class="tooltips" data-placement="top" title="Add To Cart" href="#!"><i class="fal fa-shopping-basket"></i></a></li>
                                                <li><a class="tooltips" data-placement="top" title="Quick View" href="#!" data-toggle="modal" data-target="#quickview_modal"><i class="fal fa-search"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="carparts_pagination_wrap clearfix">
                                <div class="row align-items-center justify-content-lg-between">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <button type="button" class="custom_btn bg_carparts_red text-uppercase"><i class="fas fa-arrow-circle-down mr-2"></i> Load More</button>
                                    </div>

                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <ul class="carparts_pagination_nav ul_li_right clearfix">
                                            <li class="active"><a href="#!">1</a></li>
                                            <li><a href="#!">2</a></li>
                                            <li><a href="#!">3</a></li>
                                            <li><a href="#!">...</a></li>
                                            <li><a href="#!">4</a></li>
                                            <li><a href="#!">5</a></li>
                                            <li><a href="#!">7</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <aside class="carparts_sidebar sidebar_section">
                        <div class="sb_widget sb_pricing_range">
                            <h3 class="sb_widget_title text-uppercase">Select Price</h3>
                            <form action="#">
                                <div class="price-range-area clearfix">
                                    <div id="slider-range" class="slider-range ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 2.51256%; width: 40.1005%;"></div><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 2.51256%;"></span><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 42.6131%;"></span></div>
                                    <div class="price-text d-flex align-items-center">
                                        <span>Price:</span>
                                        <input type="text" id="amount" readonly="">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="sb_widget sb_collapse_category">
                            <h3 class="sb_widget_title text-uppercase">Categories</h3>
                            <div id="sb_category_accordion" class="sb_category_accordion">
                                <div class="card">
                                    <div class="card-header">
                                        <a data-toggle="collapse" href="#collapse_one">
                                            Car Parts
                                        </a>
                                    </div>
                                    <div id="collapse_one" class="collapse show" data-parent="#sb_category_accordion">
                                        <div class="card-body p-0">
                                            <ul class="ul_li_block clearfix">
                                                <li><a href="#!">Lights</a></li>
                                                <li><a href="#!">Raincoats</a></li>
                                                <li><a href="#!">Shorts</a></li>
                                                <li><a href="#!">Pants</a></li>
                                                <li><a href="#!">Shirts</a></li>
                                                <li><a href="#!">Tires</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed" data-toggle="collapse" href="#collapse_two">
                                            Oil Filter
                                        </a>
                                    </div>
                                    <div id="collapse_two" class="collapse" data-parent="#sb_category_accordion">
                                        <div class="card-body p-0">
                                            <ul class="ul_li_block clearfix">
                                                <li><a href="#!">Lights</a></li>
                                                <li><a href="#!">Raincoats</a></li>
                                                <li><a href="#!">Shorts</a></li>
                                                <li><a href="#!">Pants</a></li>
                                                <li><a href="#!">Shirts</a></li>
                                                <li><a href="#!">Tires</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed" data-toggle="collapse" href="#collapse_three">
                                            Accessories
                                        </a>
                                    </div>
                                    <div id="collapse_three" class="collapse" data-parent="#sb_category_accordion">
                                        <div class="card-body p-0">
                                            <ul class="ul_li_block clearfix">
                                                <li><a href="#!">Lights</a></li>
                                                <li><a href="#!">Raincoats</a></li>
                                                <li><a href="#!">Shorts</a></li>
                                                <li><a href="#!">Pants</a></li>
                                                <li><a href="#!">Shirts</a></li>
                                                <li><a href="#!">Tires</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed" data-toggle="collapse" href="#collapse_four">
                                            Bags
                                        </a>
                                    </div>
                                    <div id="collapse_four" class="collapse" data-parent="#sb_category_accordion">
                                        <div class="card-body p-0">
                                            <ul class="ul_li_block clearfix">
                                                <li><a href="#!">Lights</a></li>
                                                <li><a href="#!">Raincoats</a></li>
                                                <li><a href="#!">Shorts</a></li>
                                                <li><a href="#!">Pants</a></li>
                                                <li><a href="#!">Shirts</a></li>
                                                <li><a href="#!">Tires</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed" data-toggle="collapse" href="#collapse_five">
                                            Discounted products
                                        </a>
                                    </div>
                                    <div id="collapse_five" class="collapse" data-parent="#sb_category_accordion">
                                        <div class="card-body p-0">
                                            <ul class="ul_li_block clearfix">
                                                <li><a href="#!">Lights</a></li>
                                                <li><a href="#!">Raincoats</a></li>
                                                <li><a href="#!">Shorts</a></li>
                                                <li><a href="#!">Pants</a></li>
                                                <li><a href="#!">Shirts</a></li>
                                                <li><a href="#!">Tires</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--<div class="sb_widget sb_color_checkbox">
                            <h3 class="sb_widget_title text-uppercase">Color</h3>
                            <form action="#">
                                <ul class="ul_li_block clearfix">
                                    <li>
                                        <div class="checkbox_item">
                                            <input id="black_color_checkbox" type="checkbox" checked="">
                                            <label for="black_color_checkbox">Black</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox_item">
                                            <input id="white_color_checkbox" type="checkbox">
                                            <label for="white_color_checkbox">White</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox_item">
                                            <input id="blue_color_checkbox" type="checkbox">
                                            <label for="blue_color_checkbox">Blue</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox_item">
                                            <input id="green_color_checkbox" type="checkbox" checked="">
                                            <label for="green_color_checkbox">Green</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox_item">
                                            <input id="yellow_color_checkbox" type="checkbox">
                                            <label for="yellow_color_checkbox">Yellow</label>
                                        </div>
                                    </li>
                                </ul>
                            </form>
                        </div>

                        <div class="sb_widget sb_recent_post">
                            <h3 class="sb_widget_title text-uppercase">Recent Posts</h3>
                            <div class="carparts_small_blog">
                                <a class="item_image" href="blog_details.html">
                                    <img src="assets/images/recent_post/img_06.png" alt="image_not_found">
                                </a>
                                <div class="item_content">
                                    <ul class="rating_star ul_li clearfix">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fal fa-star"></i></li>
                                    </ul>
                                    <h3 class="item_title text-uppercase">
                                        <a href="blog_details.html">
                                            earphone case
                                        </a>
                                    </h3>
                                    <div class="item_price"><strong>$29.90</strong> <del>$48.90</del></div>
                                </div>
                            </div>

                            <div class="carparts_small_blog">
                                <a class="item_image" href="blog_details.html">
                                    <img src="assets/images/recent_post/img_07.png" alt="image_not_found">
                                </a>
                                <div class="item_content">
                                    <ul class="rating_star ul_li clearfix">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fal fa-star"></i></li>
                                    </ul>
                                    <h3 class="item_title text-uppercase">
                                        <a href="blog_details.html">
                                            earphone case
                                        </a>
                                    </h3>
                                    <div class="item_price"><strong>$29.90</strong> <del>$48.90</del></div>
                                </div>
                            </div>

                            <div class="carparts_small_blog">
                                <a class="item_image" href="blog_details.html">
                                    <img src="assets/images/recent_post/img_08.jpg" alt="image_not_found">
                                </a>
                                <div class="item_content">
                                    <ul class="rating_star ul_li clearfix">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fal fa-star"></i></li>
                                    </ul>
                                    <h3 class="item_title text-uppercase">
                                        <a href="blog_details.html">
                                            earphone case
                                        </a>
                                    </h3>
                                    <div class="item_price"><strong>$29.90</strong> <del>$48.90</del></div>
                                </div>
                            </div>
                        </div>

                        <a class="text_btn text-uppercase" href="#!"><span>View More</span> <i class="fas fa-arrow-circle-right"></i></a>--}}
                    </aside>
                </div>

            </div>
        </div>
    </div>
@stop
