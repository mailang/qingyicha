<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel=stylesheet href="//res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css">
    <link rel="stylesheet" href="{{asset('wechat/css/qingyicha.css')}}">
    <link rel="stylesheet" href="{{asset('wechat/css/swiper.min.css')}}">
    <script src="{{asset('wechat/js/swiper.min.js')}}"></script>
    <title>信用查询</title>
    <!-- Demo styles -->
    <style>
        html, body {
            position: relative;
            height: 100%;
        }

        .swiper-container {
            width: 100%;
            height: 100%;
        }
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
        /*图标*/
        .nl-home-icon {
            display: block;
            margin: 0 auto;
            width: 36px;
            height: 36px;
            background-image: url({{asset('wechat/upload/product/myserver_icon.png')}});
            background-repeat: no-repeat;
            background-size: 108px;
            background-position: 0 0;
            zoom: 1.04;
        }
        .home-icon01 {
            background-position: 50% 0;
        }
        .home-icon02 {
            background-position: 50% 5%;
        }
        .home-icon08 {
            background-position: 50% 36.3%;
        }
        .home-icon09 {
            background-position: 50% 41.9%;
        }
        .home-icon04 {
            background-position: 50% 15.5%;
        }
        .home-icon11{
            background-position: 50% 52.5%;
        }
    </style>
</head><body ontouchstart>
<section class="qyc_container white-bgcolor">
    <div class="weui-tab__panel">
        <!--首页轮换图-->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="{{asset('wechat/images/slide.jpg')}}" height="200px"/></div>
                <div class="swiper-slide"><img src="{{asset('wechat/images/slide2.jpg')}}" height="200px"/></div>
                <div class="swiper-slide"><img src="{{asset('wechat/images/slide3.jpg')}}" height="200px"/></div>
                <div class="swiper-slide"><img src="{{asset('wechat/images/slide4.jpg')}}" height="200px"/></div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
        <!--
        @foreach($products as $product)
        <div class="weui-grids ">
            <a href="javascript:;" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{asset('wechat/images/foot-3.svg')}}" alt="">
                </div>
                <p class="weui-grid__label">银行</p>
            </a>
        </div>
        @endforeach
        -->
        <div class="weui-grids ">
            <a href="{{route('credit.apply')}}" class="weui-grid">
                <div class="weui-grid__icon">
                    <i class="nl-home-icon home-icon11"></i>
                </div>
                <p class="weui-grid__label">普通查询</p>
            </a>
            <a href="javascript:;" class="weui-grid">
                <div class="weui-grid__icon">
                    <i class="nl-home-icon home-icon02"></i>
                </div>
                <p class="weui-grid__label">社保</p>
            </a>
            <a href="javascript:;" class="weui-grid">
                <div class="weui-grid__icon">
                    <i class="nl-home-icon home-icon01"></i>
                </div>
                <p class="weui-grid__label">公积金</p>
            </a>
            <a href="javascript:;" class="weui-grid">
                <div class="weui-grid__icon">
                    <i class="nl-home-icon home-icon09"></i>
                </div>
                <p class="weui-grid__label">淘宝</p>
            </a>
            <a href="javascript:;" class="weui-grid">
                <div class="weui-grid__icon">
                    <i class="nl-home-icon home-icon08"></i>

                </div>
                <p class="weui-grid__label">支付宝报告</p>
            </a>
            <a href="javascript:;" class="weui-grid">
                <div class="weui-grid__icon">
                    <i class="nl-home-icon home-icon04"></i>
                </div>
                <p class="weui-grid__label">京东报告</p>
            </a>
        </div>
    </div>

</section>

@include('wechat.layouts.footer')
<script type="text/javascript">
    <!-- Initialize Swiper -->
    var swiper = new Swiper('.swiper-container', {
        pagination: {
            el: '.swiper-pagination',
            dynamicBullets: true,
            autoplay:true,
            loop:true,
        },
    });
</script>
</body>
</html>