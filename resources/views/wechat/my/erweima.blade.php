@include('wechat.layouts.header')
<body>
<section class="qyc_container">
    <div class="weui-tab__panel">
        <div class="home-head white-bgcolor clearfix">
            <div class="head-img">

            </div>
        </div>
        <div class="weui-cells">
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <img src="{{$url}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
@include('wechat.layouts.footer')
</body>
</html>