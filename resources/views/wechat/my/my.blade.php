@include('wechat.layouts.header')
<body>
<section class="qyc_container">
    <div class="weui-tab__panel">
        <div class="home-head white-bgcolor clearfix">
            <div class="head-img">
                <div class="head-logo"><img src="{{$_SESSION['wechat_user']['avatar']}}" alt=""></div>
                <div class="head-name">{{$_SESSION['wechat_user']['nickname']}}</div>
            </div>
        </div>
        <div class="weui-cells">
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <p class="choose-text"><img src="{{asset('wechat/images/home-1.svg')}}" alt=""> 查询记录</p>
                </div>
                <div class="weui-cell__ft"><a class="tips" href="{{route('order.list','all')}}}">查看所有记录</a></div>
            </div>
        </div>
        <div class="weui-flex home-order white-bgcolor mb-625">
           <!--
            <a href="orderlist.html" class="weui-flex__item">
                <div class="weui-flex__icon">
                    <img src="{{asset('wechat/images/home-4.svg')}}" alt="">
                </div>
                <p class="weui-flex__label">近一天</p>
            </a>
            <a href="orderlist.html" class="weui-flex__item">
                <div class="weui-flex__icon">
                    <img src="{{asset('wechat/images/home-4.svg')}}" alt="">
                </div>
                <p class="weui-flex__label">近一周</p>
            </a>
            -->
            <a href="{{route('order.list','month')}}" class="weui-flex__item">
                <div class="weui-flex__icon">
                    <img src="{{asset('wechat/images/home-4.svg')}}" alt="">
                </div>
                <p class="weui-flex__label">近一月</p>
            </a>
        </div>
        <div class="weui-cells">
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <p class="choose-text"><img src="{{asset('wechat/images/home-4.svg')}}" alt=""> 我的资料</p>
                </div>
                <div class="weui-cell__ft"></div>
            </div>
        </div>
        <div class="weui-cells">
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <p class="choose-text"><img src="{{asset('wechat/images/foot-5-1.svg')}}" alt=""> 关于我们</p>
                </div>
                <div class="weui-cell__ft"></div>
            </div>
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <p class="choose-text"><img src="{{asset('wechat/images/home-5.svg')}}" alt=""> 意见反馈</p>
                </div>
                <div class="weui-cell__ft"></div>
            </div>
        </div>
    </div>
</section>
@include('wechat.layouts.footer')
</body>
</html>