@include('wechat.layouts.header')
<body class="white-bgcolor">
<section class="qyc_container">
    <div class="headTop">
        <a href="javascript:history.go(-1)" class="back"><i class="iconBack"></i></a><span>{{$product->pro_name}}</span>
    </div>
    <div class="weui-tab__panel">
        <div class="bgfff form ov">
            <div class="fb">免责申明：</div>
            <p class="font_p pt15">请认真阅读以下协议，在提交信息之前，你必须接受此协议的条款。</p>
            <div class="xieyi">
                <p>
                    一、声明与承诺
                    <br>
                    （一）本公司一贯重视消费者权益保护，故本协议已对本公司认为的与您的权益有或可能有重大关系的条款及对本公司具有或可能具有免责或限制责任的条款用粗体字予以标注（例如第十一条法律适用与管辖），请您务必注意。您理解并承诺，在您注册成为芝麻信用用户以接受本服务，或您以本公司允许的其他方式实际使用本服务前，您已充分阅读、理解并接受本协议的全部内容，您使用本服务，即表示您同意遵循本协议之所有约定。
                    <br>（二）作为本协议服务的提供方，本公司有权根据情况的需要对本协议内容进行变更，变更的原因包括但不限于国家法律、法规及其他规范性文件的规定变化，增加、变更了新的服务类型或服务方式，进一步明确协议双方的权利义务。因本协议所涉服务的性质独特及服务用户数量众多，故本公司在对本协议内容进行变更时，不会另行单独通知您，该等变更只会以在本网站或其他适当的地方公告的方式予以公布；您在本协议内容公告变更后继续使用本服务，表示您已充分阅读、理解并接受变更后的协议内容，并遵循变更后的协议内容而使用本服务；若您不同意修改后的协议内容，您应停止使用本服务。
                    <br>（三）您理解并同意，本协议规定的内容既包括《征信业管理条例》中征信业务所涉及的本公司提供的服务，亦包括本公司提供的其他服务，所以您应当对于《征信业管理条例》及相关法律法规有适当的了解，如您不能清楚地知晓或理解国家相关法律法规规定的内容，您应当咨询相关法律专业人士后再决定是否接受本协议。
                    <br>（四）您保证，作为自然人，在您同意接受本协议并注册成为芝麻信用用户时，您已经年满16周岁；作为企业、事业单位等组织，您在中华人民共和国（“中国”）大陆地区（不含香港、台湾、澳门地区）合法开展经营活动或其他业务，或依照中国大陆地区（不含香港、台湾、澳门地区）法律登记注册成立；本协议内容不受您所属国家或地区法律的约束。不具备前述条件的，您应立即终止注册或停止使用本服务。
                </p>
                <p>二、定义及解释
                    <br>（一）芝麻信用账户：指用户按照本协议第四条第（一）款注册使用的账户。
                    <br> （二）本网站：除本协议另有规定外，指相关移动客户端应用程序或域名为zmxy.antgroup.com的网站。
                    <br> （三）人：指依照中国大陆地区（不含香港、台湾、澳门地区）法律具有民事权利能力的主体，包括自然人、法人和其他组织。
                    <br>（四）用户：如无特别说明，指符合本协议要求，使用本服务的自然人（“个人用户”）和企业、事业单位等组织（“企业用户”）。如无特别规定，本协议内写明“您”和“用户”的地方应当包括个人用户与企业用户。
                    <br>（五）信息提供者：指本公司向其采集用户信息的人和其他从其采集用户信息的渠道来源。
                    <br>（六）支付宝账户：指依照支付宝（中国）网络技术有限公司（以下简称“支付宝公司”）与其用户签订的《支付宝服务协议》，由支付宝公司向其用户分配的账户，协议内容以支付宝公司所运营的网站www.alipay.com上公布的最新版本为准。
                    <br>（七）支付宝登录名：指用以登录支付宝账户的字符和/或数字标识，具体以支付宝公司允许的为准。
                    <br> （八）支付宝快捷登录：就本协议而言，指支付宝公司提供的一种登录方案，该登录方案使得用户登录其支付宝账户便可登录其芝麻信用账户。
                    <br>（九）“书面”或“书面形式”：如无特别说明或约定，纸质（或其他材质，例如电子书写板）函件、合同书、信件和数据电文、电报、电传、传真、电子数据交换、电子邮件、网络合同、网络授权函等可以有形地表现其所记载内容的形式均是书面形式。
                </p>
            </div>
        </div>
        <div class="weui-cells weui-cells_checkbox" style="margin-top: 0;">
            <label class="weui-cell weui-check__label" for="c1"> <div class="weui-cell__hd"> <input pattern="{1}" type="checkbox" class="weui-check" name="assistance" id="reader"> <i class="weui-icon-checked"></i> </div> <div class="weui-cell__bd" style="font-size: 12px">本人已阅读协议内容并接受协议各条款</div> </label>
        </div>
        <input type="hidden" value="{{$product->id}}" id="proid">
        <div class="weui-btn-area"> <a id="SubmitBtn" href="javascript:" class="weui-btn radio_disable" disable="false">支付{{$product->price}}元进行查询</a> </div>
    </div></section>
@include('wechat.layouts.footer')
<script src="//res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script>

    $(function () {
        wx.config(<?php echo app('wechat.official_account')->jssdk->buildConfig(array('chooseWXPay'), false) ?>);
        wx.ready(function(){
            $(".weui-cell__hd").click(function () {
                if ($("#reader").prop("checked"))
                {
                    $("#SubmitBtn").addClass('weui-btn_primary').removeClass('radio_disable');
                    $("#SubmitBtn").prop('disable',false);
                }
                else
                {
                    $("#SubmitBtn").addClass('radio_disable').removeClass('weui-btn_primary');
                    $("#SubmitBtn").prop('disable',true);
                }
            });
           $("#SubmitBtn").click(function () {
                $.ajax({
                    url: '{{route('order.create',$product->id)}}',
                    type: 'get',
                    datatype: 'json',
                    success: function (data) {
                        if(data!="") {
                            $re = $.parseJSON(data);
                            wx.chooseWXPay({
                                timestamp: $re["timestamp"],
                                nonceStr: $re["nonceStr"],
                                package: $re["package"],
                                signType: $re["signType"],
                                paySign: $re["paySign"], // 支付签名
                                success: function (res) {
                                    //支付成功后的回调函数
                                    //支付成功后生成征信报告
                                    // 支付成功后的回调函数
                                    if (res.errMsg == "chooseWXPay:ok") {
                                        //支付成功
                                        window.location.href ="/weixin/order/info/"+$re["order_id"];
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