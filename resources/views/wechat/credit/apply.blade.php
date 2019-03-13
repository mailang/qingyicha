@include('wechat.layouts.header')
<body ontouchstart>
    <section class="qyc_container">
    <div class="weui-tab__panel"> <form id="form1" novalidate><input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="weui-cells__title"><img src="{{asset('wechat/images/arrow.png')}}" width="30px" alt=""><font style="color:#484646; font-weight: bold;">&nbsp;基本信息</font></div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">真实姓名</label></div>
            <div class="weui-cell__bd">
                <input id="name" name="name" class="weui-input" type="text" required="" placeholder="请输入您的真实姓名">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label">身份证号码</label></div>
            <div class="weui-cell__bd">
                <input id="cardNo" name="cardNo" class="weui-input" type="text" required="" pattern="REG_IDNUM"
                       maxlength="18" placeholder="请输入本人身份证" emptytips="请输入本人身份证" notmatchtips="请输入正确的身份证号码">
            </div>
        </div>
        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd">
                <label class="weui-label">手机号</label>
            </div>
            <div class="weui-cell__bd">
                <input id="phone" name="phone" class="weui-input" type="tel" required="" pattern="^\d{11}$"
                       maxlength="11" placeholder="请输入本人的手机号" emptytips="请输入本人的手机号" notmatchtips="请输入正确的手机号">
            </div>
            <div class="weui-cell__ft">
                <button id="code" class="weui-vcode-btn">获取验证码</button>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">短信验证码</label></div>
            <div class="weui-cell__bd">
                <input id="valicode" name="valicode" class="weui-input" type="text" placeholder="请输入验证码">
            </div>
        </div>
        <label class="weui-cell weui-cells_checkbox" style="margin-top: 0;">
            <input type="checkbox" class="weui-check" name="assistance" id="reader">
            <i class="weui-icon-checked"></i>
            <span class="weui-agree__text">
                阅读并同意<a href="{{route('wechat.xieyi')}}">《相关条款》</a>
                </span>
        </label>
</form>
        <div class="weui-cell">
            <input type="submit" value="支付（{{$product->price}}元）" id="btnsubmit"  class="weui-btn radio_disable"/></div>
    </div></section>

@include('wechat.layouts.footer')
<script src="{{asset('wechat/js/jquery.form.js')}}"></script>
<script src="//res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script>
    //var loading = weui.loading('');
    $(function () {
        var regexp = {
            regexp: {
                IDNUM: /(?:^\d{15}$)|(?:^\d{18}$)|^\d{17}[\dXx]$/
            }
        };
        function checkbtn() {
            if ($("#reader").prop("checked")) {
                $("#btnsubmit").addClass('weui-btn_primary').removeClass('radio_disable');
                $("#btnsubmit").prop('disabled', false);
            }
            else {
                $("#btnsubmit").addClass('radio_disable').removeClass('weui-btn_primary');
                $("#btnsubmit").prop('disabled', true);
            }
        }
        $("#reader").change(function () {
            checkbtn();
        });
        wx.config(<?php echo app('wechat.official_account')->jssdk->buildConfig(array('chooseWXPay'), false) ?>);
        wx.ready(function(){
            weui.form.validate('#form1', function (error) {
                $("#btnsubmit").click(function () {
                    $name = $("#name").val();
                    $num = $("#cardNo").val();
                    $tel = $("#phone").val();
                    $code = $.trim($("#valicode").val());
                    if (!error) {
                        if ($code.trim().equals("")) {
                            weui.topTips("请输入验证码");
                            return;
                        }
                        $.ajax({
                            url: '{{route('order.create',$product->id)}}',
                            type: 'post',
                            datatype: 'json',
                            data: {
                                'name': $name,
                                'cardNo': $num,
                                'phone': $tel,
                                'telcode': $code,
                                '_token': '{{csrf_token()}}'
                            },
                            success: function (data) {
                                if (data != null) {
                                    if(data.equals(-1))   weui.toast("验证码不存在");
                                    if(data.equals(-2))   weui.toast("验证码已失效");
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
                    }
                });
            }, regexp);
        });
        wx.error(function(res){
            // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
            alert(res);
        });
        countdown = 60;

        function settime(that) {
            var code = $(that);
            if (countdown == 0) {
                code.removeAttr('disabled');
                code.text("获取验证码");
                countdown = 60;
                return;
            } else {
                code.text("重新发送(" + countdown + ")");
                code.attr('disabled', true);
                countdown--;
            }
            setTimeout(function () {
                settime(that)
            }, 1000);
        }

        $("#code").click(function () {
            that = this;
            $name = $("#name").val();
            $num = $("#cardNo").val();
            $tel = $("#phone").val();
            weui.form.validate('#form1', function (error) {
                if (!error) {
                    settime(that);
                    $.ajax({
                        url: "{{route('Qcode.sms')}}",
                        type: 'get',
                        datatype: "text",
                        data: {'phone': $tel},
                        success: function (data) {
                            weui.toast(data, 3000);
                        }
                    });
                }
            }, regexp);
            return false;
        });

    });

</script>

 </body>
</html>