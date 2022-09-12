@extends('layouts.app')
@section('content')

    @include('partials.menu.mobile')

    <!-- supermarket_feature_carousel - start
			================================================== -->
    <section class="supermarket_feature_carousel arrow_ycenter clearfix" data-slick='{"dots": false}'>
        @foreach($randomProducts->random(3) as $item)
            <div class="item sec_ptb_50 d-flex align-items-center" data-bg-color="#18171c">
                <div class="container maxw_1460">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-7 order-last">
                            <div class="item_image">
                                <img style="width: 839px; height: 566px !important;" src="{{ $item->getImage() }}" alt="image_not_found">
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="item_content">
                                <span class="item_price">₸ {{ $item->getPriceFormatter() }}</span>
                                <h3 class="item_title text-white mb_30">
                                    {{ $item->name }}
                                </h3>
                                <a class="custom_btn btn_round bg_electronic_blue" href="#!">Купить сейчас</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </section>
    <!-- supermarket_feature_carousel - end
			================================================== -->

    @include('partials.policy_section')

    @include('partials.bestseller_products')


    @include('partials.bestseller2')
@stop
