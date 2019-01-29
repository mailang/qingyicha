@include('wechat.layouts.header')
<body class="white-bgcolor">
<section class="qyc_container">
    <div class="page__bd">
        <div class="headTop">
            <a href="javascript:history.go(-1)" class="back"><i class="iconBack"></i></a><span>订单详情</span><a class="more"><i class="iconDian"></i><i class="iconDian"></i><i class="iconDian"></i></a>
        </div>
        <div class="weui-cell" style="border-bottom: 1px solid #eee;">
            <div>
                <span style="display: block;color: green; font-size: 12px;">订单状态：
                    <?php
                       switch($order->state)
                       {
                           case 0:echo "待支付";break;
                           case 1:echo "已付款";break;
                           case 2:echo "已完成";break;
                           case 3:echo "已完成";break;
                           case -1:echo "已超时";break;
                           case -2:echo "支付失败";break;
                           case -3:echo "已退款";break;
                       }
                    ?>
                 </span>
                <br>
                <span>订单编号：{{$order->out_trade_no}}</span>
            </div>
        </div>

        <div class="weui-cell weui-cell_access order_list">
            <div class="weui-cell__hd"><img src=" {{$order->icon}}" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui-cell__bd">
                <p>{{$order->pro_name}}</p>
            </div>
            <a  href="javascript:;"><div class="weui-cell__ft"></div>  </a>
        </div>
        <div class="weui-cell ">
            <div class="weui-cell__hd"><label class="weui-label font12">商品总额：</label></div>
            <div class="weui-cell__bd font12" style="text-align: right;">
                {{$order->total_fee}}
            </div>
        </div>
        <div class="weui-cell font12" style="border-bottom: 1px solid #eee;">
            <div>下单时间：<span style="float: right;"> {{$order->time_start}}</span> </div>
            @if($order->state==0)
        </div><div  class="weui-cell font12">
                 <div><span class="font_red" style="float: right;">
                         <a id="SubmitBtn" href="javascript:" class="weui-btn  weui-btn_primary">去支付</a>
                     </span></div>
            @else
                <br> <div>  实付金额：<span class="font_red" style="float: right;">¥{{$order->total_fee}}</span> </div>
            @endif
        </div>
        <div style="margin: 3em 1em;">
            <a href="{{route('weixin.index')}}" class="weui-btn weui-btn_primary">回首页逛逛</a>
        </div>
    </div></section>
@include('wechat.layouts.footer')
<script>
    $("#SubmitBtn").click(function () {
        wx.config(<?php echo app('wechat.official_account')->jssdk->buildConfig(array('chooseWXPay'), true) ?>);
wx.ready(function(){
$.ajax({
url: '{{route('order.recreate',$order->id)}}',
type: 'get',
datatype: 'json',
success: function (data) {
$re=$.parseJSON(data);
wx.chooseWXPay({
timestamp:$re["timestamp"],
nonceStr: $re["nonceStr"],
package: $re["package"],
signType:$re["signType"],
paySign: $re["paySign"], // 支付签名
success: function (res) {
if (res.errMsg == "chooseWXPay:ok") {
//支付成功
window.location.href='{{route('order.info',$order->id)}}';
} else {
weui.toast(res.errMsg);
}
},
cancel: function(res) {
//支付取消
weui.toast('支付取消');
}
});
},
error: function () {weui.toast('系统故障');}
});
});
wx.error(function(res){
// config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
            alert(res);
        });
});



</script>
</body>
</html>