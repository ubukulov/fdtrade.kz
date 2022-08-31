<div class="item clearfix" data-bg-color="#ffc156">
    <div class="slider_image order-last" data-animation="fadeInUp" data-delay=".2s">
        <img src="{{ $hit_product->getImage() }}" alt="image_not_found">
    </div>
    <div class="slider_content">
        <h3 data-animation="fadeInUp" data-delay=".6s">{{ $hit_product->name }}</h3>
        <div class="item_price" data-animation="fadeInUp" data-delay=".8s">
            <sup>₸</sup>{{ $hit_product->getPriceFormatter() }}
        </div>
        <div class="abtn_wrap clearfix" data-animation="fadeInUp" data-delay="1s">
            <a href="#!" class="custom_btn btn_round bg_supermarket_red">Купить сейчас</a>
        </div>
    </div>
</div>
