@include('wechat.layouts.header')
<body ontouchstart>
<form id="form1">
    <section class="qyc_container">
        <div class="weui-tab__panel"> <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input id="order_id" type="hidden" value="{{$order_id}}" name="order_id">
            <div class="weui-cells__title"><img src="{{asset('wechat/images/arrow.png')}}" width="30px" alt=""><font style="color:#484646; font-weight: bold;">&nbsp;基本信息</font></div>
            <div class="weui-cell white-bgcolor">
                <div class="weui-cell__hd"><label class="weui-label">真实姓名</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" id="name" name="name" type="text" value="{{$oauth->name}}" disabled="disabled" placeholder="请输入文本">
                </div>
            </div>
            <div class="weui-cell white-bgcolor"> <div class="weui-cell__hd">
                    <label class="weui-label">身份证号码</label></div>
                <div class="weui-cell__bd"> <input id="cardNo" name="cardNo" class="weui-input" disabled="disabled" value="{{$oauth->cardNo}}" required="" pattern="REG_IDNUM" maxlength="18" placeholder="输入你的身份证号码" emptytips="请输入身份证号码" notmatchtips="请输入正确的身份证号码" type="text">
                </div>
            </div>
            <div class="weui-cell white-bgcolor">
                <div class="weui-cell__hd">
                    <label class="weui-label">手机号</label>
                </div>
                <div class="weui-cell__bd">
                    <input id="phone" name="phone" class="weui-input" type="tel" disabled="disabled" value="{{$oauth->phone}}"  placeholder="输入你现在的手机号">            </div>
            </div>
            <div class="weui-cell">
                <input type="submit" value="立即查询" id="btnsubmit"  class="weui-btn weui-btn_primary" /></div>
        </div></section>
</form>
@include('wechat.layouts.footer')
<script src="{{asset('wechat/js/jquery.form.js')}}"></script>
<script>

    $(function () {
        var regexp = {
            regexp: {
                IDNUM: /(?:^\d{15}$)|(?:^\d{18}$)|^\d{17}[\dXx]$/
            }
        }
        $("#btnsubmit").click(function ()
        {
            weui.form.validate('#form1', function(error){
                if (!error) {
                    var loading = weui.loading('提交中...');
                    $("#form1").ajaxForm({
                        url:'{{route('apply.store')}}',
                        type:"post",
                        datatype:'text',
                        success:function (data) {
                            loading.hide();
                            location.href="/weixin/apply/success/"+$("#order_id").val();
                            //weui.toast('提交成功', 3000);
                        },
                        error:function () {
                            weui.toast('服务出错', 3000);
                        }
                    });

                }},regexp);
        });
    });
</script>
</body>
</html>