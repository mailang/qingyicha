@include('wechat.layouts.header')
<body class="white-bgcolor">
<section class="qyc_container">
    <div class="page__bd">
        <div class="headTop">
            <a href="javascript:history.go(-1)" class="back"><i class="iconBack"></i></a><span>{{$api["api_name"]=="personalComplaintInquiry"?"个人":"企业"}}涉诉详情</span><a class="more"><i class="iconDian"></i><i class="iconDian"></i><i class="iconDian"></i></a>
        </div>
        @if($api["api_name"]=="enterpriseLitigationInquiry")
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label">购买服务:</label></div>
                <div class="weui-cell__bd">
                    企业涉诉全类
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label">企业名:</label></div>
                <div class="weui-cell__bd">
                    {{$api["name"]}}
                </div>
            </div>
            @else
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label">购买服务:</label></div>
                <div class="weui-cell__bd">
                    个人涉诉
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label">姓名:</label></div>
                <div class="weui-cell__bd">
                    {{$api["name"]}}
                </div>
            </div>
        @endif
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label">购买页面</label></div>
            <div class="weui-cell__bd">
            第{{$api["page"]}}页
            </div>
        </div>
        <div class="weui-cell">
            <input type="submit" value="支付（1元）" id="btnsubmit"  class="weui-btn radio_disable"/></div>
    </div></section>
@include('wechat.layouts.footer')
<script>
    $(function () {
        wx.config(<?php echo app('wechat.official_account')->jssdk->buildConfig(array('chooseWXPay'), false) ?>);
        wx.ready(function(){
            $("#btnsubmit").click(function () {
                        $.ajax({
                            url: '{{route('order.create',1)}}',
                            type: 'get',
                            datatype: 'json',
                            success: function (data) {
                                if (data != null) {
                                    var re = $.parseJSON(data);
                                    wx.chooseWXPay({
                                        timestamp: re["timestamp"],
                                        nonceStr: re["nonceStr"],
                                        package: re["package"],
                                        signType: re["signType"],
                                        paySign: re["paySign"], // 支付签名
                                        success: function (res) {
                                            //支付成功后的回调函数
                                            //支付成功后生成征信报告
                                            // 支付成功后的回调函数
                                            if (res.errMsg == "chooseWXPay:ok") {
                                                //支付成功
                                                window.location.href = "/weixin/order/payback/" + re["order_id"];
                                            } else {
                                                weui.toast(res.errMsg);
                                            }
                                        },
                                        cancel: function (res) {
                                            //支付取消
                                            weui.toast('支付取消');
                                        }
                                    });
                                }
                            },
                            error: function () {
                                weui.toast('系统故障');
                            }
                        });
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