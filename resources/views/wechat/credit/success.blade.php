@include('wechat.layouts.header')
<body class="white-bgcolor">
<section class="qyc_container">
    <div class="headTop">
        <a href="javascript:history.go(-1)" class="back"><i class="iconBack"></i></a><span>信用查询</span>
    </div>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">操作成功</h2>
            <p class="weui-msg__desc">如果信用查询结果失败，进入我的订单详情可以点击重新查询</p>
        </div>
        <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
                <a href="{{route('order.report',$id)}}" class="weui-btn weui-btn_primary">查看报告</a>
                <a href="{{route('weixin.index')}}" class="weui-btn weui-btn_default">回首页逛逛</a>
            </p>
        </div>
        <div class="weui-msg__extra-area">
            <div class="weui-footer">
                <p class="weui-footer__links">
                    <a href="javascript:void(0);" class="weui-footer__link">底部链接文本</a>
                </p>
                <p class="weui-footer__text"></p>
            </div>
        </div>
    </div>
</section>
@include('wechat.layouts.footer')
</body>
</html>