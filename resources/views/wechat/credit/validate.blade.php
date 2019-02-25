@include('wechat.layouts.header')
<body class="white-bgcolor">
<form id="form1" novalidate>
    <section class="qyc_container">
        <div class="weui-tab__panel">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="weui-cells__title"><img src="{{asset('wechat/images/arrow.png')}}" width="30px" alt=""><label
                        style="color:#484646; font-weight: bold;font-size: large">&nbsp;实名认证</label></div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">真实姓名</label></div>
                <div class="weui-cell__bd">
                    <input id="name" name="name" class="weui-input" type="text" required="" placeholder="请输入姓名">
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label">身份证号码</label></div>
                <div class="weui-cell__bd">
                    <input id="cardNo" name="cardNo" class="weui-input" type="text" required="" pattern="REG_IDNUM"
                           maxlength="18" placeholder="输入你的身份证号码" emptytips="请输入身份证号码" notmatchtips="请输入正确的身份证号码">
                </div>
            </div>
            <div class="weui-cell weui-cell_vcode">
                <div class="weui-cell__hd">
                    <label class="weui-label">手机号</label>
                </div>
                <div class="weui-cell__bd">
                    <input id="phone" name="phone" class="weui-input" type="tel" required="" pattern="^\d{11}$"
                           maxlength="11" placeholder="输入你现在的手机号" emptytips="请输入手机号" notmatchtips="请输入正确的手机号">
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
            <div class="weui-btn-area">
                <input type="submit" value="提交" id="btnsubmit" class="weui-btn radio_disable" disabled="true"/>
            </div>
        </div>
    </section>
</form>
@include('wechat.layouts.footer')
<script>
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

        weui.form.checkIfBlur('#form1', regexp);

        $("#btnsubmit").click(function () {
            $name = $("#name").val();
            $num = $("#cardNo").val();
            $tel = $("#phone").val();
            $code = $.trim($("#valicode").val());

            weui.form.validate('#form1', function (error) {

                if (!error) {
                    if ($code == "") {
                        weui.topTips("请输入验证码");
                        return;
                    }
                    $.ajax({
                        url: "{{route('authorization.store')}}",
                        type: 'post',
                        datatype: "text",
                        data: {
                            'name': $name,
                            'cardNo': $num,
                            'phone': $tel,
                            'telcode': $code,
                            '_token': '{{csrf_token()}}'
                        },
                        success: function (data) {
                            if (data == "认证成功") {
                                weui.confirm('您已授权成功！', function () {
                                    window.location.href="{{$reurl}}";
                                }, function () {
                                    console.log('no')
                                });
                            }
                            else alert(data);//  weui.toast(data, 3000);
                        },
                        error: function () {
                            alert('系统服务出错');
                        }
                    });
                }

            }, regexp);
            return false;

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
                        url: "{{route('validate.code')}}",
                        type: 'get',
                        datatype: "text",
                        data: {'name': $name, 'cardNo': $num, 'phone': $tel},
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