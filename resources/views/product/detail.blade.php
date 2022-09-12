@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row mb_100 justify-content-lg-between">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="shop_details_image">
                    <div class="tab-content">
                        @foreach($product->images as $img)
                        <div id="tab_1" class="tab-pane @if($loop->iteration == 1) active @endif">
                            <img @if($product->category_id > 566) src="/uploads/products/{{ $img->path }}" @else src="{{ $img->path }}" @endif alt="image_not_found">
                        </div>
                        @endforeach
                    </div>

                    <ul class="nav ul_li clearfix" role="tablist">
                        @foreach($product->images as $img)
                        <li>
                            <a @if($loop->iteration == 1) class="active" @endif data-toggle="tab" href="#tab_1">
                                <img @if($product->category_id > 566) src="/uploads/products/{{ $img->path }}" @else src="{{ $img->path }}" @endif alt="image_not_found">
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="shop_details_content">
                    <div class="rating_review_wrap d-flex align-items-center mb_15 clearfix">
                        <ul class="rating_star ul_li">
                            <li><i class="fas fa-star"></i></li>
                            <li><i class="fas fa-star"></i></li>
                            <li><i class="fas fa-star"></i></li>
                            <li><i class="fas fa-star"></i></li>
                            <li><i class="fas fa-star"></i></li>
                        </ul>
{{--                        <span>4 Review(s)</span>--}}
{{--                        <button type="button" class="add_review_btn">Add Your Review</button>--}}
                    </div>
                    <h2 class="item_title mb-2">{{ $product->name }}</h2>

                    <hr>

                    {{--<div class="option_select">
                        <h4 class="list_title mb_15 text-uppercase">Year</h4>
                        <select style="display: none;">
                            <option data-display="Select">Nothing</option>
                            <option value="1">Some option</option>
                            <option value="2">Another option</option>
                            <option value="3" disabled="">A disabled option</option>
                            <option value="4">Potato</option>
                        </select><div class="nice-select" tabindex="0"><span class="current">Select</span><ul class="list"><li data-value="Nothing" data-display="Select" class="option selected">Nothing</li><li data-value="1" class="option">Some option</li><li data-value="2" class="option">Another option</li><li data-value="3" class="option disabled">A disabled option</li><li data-value="4" class="option">Potato</li></ul></div>
                    </div>

                    <div class="option_select">
                        <h4 class="list_title mb_15 text-uppercase">Make</h4>
                        <select style="display: none;">
                            <option data-display="Select">Nothing</option>
                            <option value="1">Some option</option>
                            <option value="2">Another option</option>
                            <option value="3" disabled="">A disabled option</option>
                            <option value="4">Potato</option>
                        </select><div class="nice-select" tabindex="0"><span class="current">Select</span><ul class="list"><li data-value="Nothing" data-display="Select" class="option selected">Nothing</li><li data-value="1" class="option">Some option</li><li data-value="2" class="option">Another option</li><li data-value="3" class="option disabled">A disabled option</li><li data-value="4" class="option">Potato</li></ul></div>
                    </div>

                    <div class="option_select">
                        <h4 class="list_title mb_15 text-uppercase">Model</h4>
                        <select style="display: none;">
                            <option data-display="Select">Nothing</option>
                            <option value="1">Some option</option>
                            <option value="2">Another option</option>
                            <option value="3" disabled="">A disabled option</option>
                            <option value="4">Potato</option>
                        </select><div class="nice-select" tabindex="0"><span class="current">Select</span><ul class="list"><li data-value="Nothing" data-display="Select" class="option selected">Nothing</li><li data-value="1" class="option">Some option</li><li data-value="2" class="option">Another option</li><li data-value="3" class="option disabled">A disabled option</li><li data-value="4" class="option">Potato</li></ul></div>
                    </div>--}}

                    {{--<div class="item_color_list mb_30 clearfix">
                        <h4 class="list_title mb_15 text-uppercase">Color</h4>
                        <ul class="ul_li clearfix">
                            <li>
                                <button type="button"><span><small data-bg-color="#cc7b4a" style="background: rgb(204, 123, 74);"></small></span> Brown</button>
                            </li>
                            <li>
                                <button type="button"><span><small data-bg-color="#b6b8ba" style="background: rgb(182, 184, 186);"></small></span> Grey</button>
                            </li>
                            <li>
                                <button type="button"><span><small data-bg-color="#dd3333" style="background: rgb(221, 51, 51);"></small></span> Red</button>
                            </li>
                        </ul>
                    </div>--}}

                    <ul class="btns_group_1 ul_li mb_30 clearfix">
                        <li>
                            <div class="quantity_input">
                                <form action="#">
                                    <span class="input_number_decrement">–</span>
                                    <input class="input_number" type="text" value="1">
                                    <span class="input_number_increment">+</span>
                                </form>
                            </div>
                        </li>
                        <li>
                            <a class="custom_btn bg_black text-uppercase" href="#!"><i class="fal fa-shopping-bag mr-2"></i> Заказать</a>
                        </li>
                    </ul>

                    <hr>

                    <ul class="product_info ul_li_block mb_30 clearfix">
                        <li><strong>Цена:</strong> {{ $product->getPriceFormatter() }} ₸</li>
                        <li><strong>SKU:</strong> {{ $product->article }}</li>
                    </ul>

                    <div class="share_links d-flex align-items-center">
                        <h4 class="list_title text-uppercase mb-0">Поделиться:</h4>
                        <ul class="circle_social_links ul_li_right clearfix">
                            <li><a href="#!"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#!"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#!"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#!"><i class="fab fa-whatsapp"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="details_description_tab">
            <ul class="nav ul_li_center text-uppercase" role="tablist">
                <li>
                    <a class="active" data-toggle="tab" href="#description_tab">Описание</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#reviews_tab">Отзывы</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#information_tab">Характеристики</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="description_tab" class="tab-pane active">
                    @if($product->category_id > 566)
                        <p class="mb-0">
                            {!! $product->description !!}
                        </p>
                    @else
                        <p class="mb-0">
                            {!! $product_feature[0]->detailtext !!}
                        </p>
                    @endif
                </div>

                <div id="reviews_tab" class="tab-pane fade">
                    <form action="#">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form_item">
                                    <input type="text" name="name" placeholder="Your Name">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form_item">
                                    <input type="email" name="email" placeholder="Your Email">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form_item">
                                    <input type="text" name="subject" placeholder="Subject">
                                </div>
                            </div>
                        </div>

                        <div class="form_item">
                            <textarea name="message" placeholder="Your Message"></textarea>
                        </div>
                        <button type="submit" class="custom_btn bg_default_red text-uppercase">Submit Review</button>
                    </form>
                </div>

                <div id="information_tab" class="tab-pane fade">
                    @if(isset($product_feature[0]))
                        @foreach($product_feature[0]->properties as $key=>$val)
                            <p><strong>{{ $key }}</strong>: {{ $val }}</p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
