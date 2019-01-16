@include('wechat.layouts.header')
<body>
<form id="form1">
    <section class="qyc_container white-bgcolor">
    <div class="weui-tab__panel">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">真实姓名</label></div>
            <div class="weui-cell__bd">
                <input id="name" name="name" class="weui-input" type="text" required="" placeholder="请输入姓名">
            </div>
        </div>
        <div class="weui-cell"> <div class="weui-cell__hd">
                <label class="weui-label">身份证号码</label></div>
            <div class="weui-cell__bd">
                <input id="cardNo" name="cardNo" class="weui-input" type="text" required="" pattern="REG_IDNUM" maxlength="18" placeholder="输入你的身份证号码" emptytips="请输入身份证号码" notmatchtips="请输入正确的身份证号码">
            </div>
            </div>
        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd">
                <label class="weui-label">手机号</label>
            </div>
            <div class="weui-cell__bd">
                <input id="phone" name="phone" class="weui-input" type="tel" required="" pattern="^\d{11}$" maxlength="11" placeholder="输入你现在的手机号" emptytips="请输入手机号" notmatchtips="请输入正确的手机号">
            </div>
            <div class="weui-cell__ft">
                <button id="code" class="weui-vcode-btn">获取验证码</button>
            </div>
        </div>
      <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">短信验证码</label></div>
            <div class="weui-cell__bd">
                <input id="valicode" name="valicode" class="weui-input" type="text"  placeholder="请输入验证码">
            </div>
        </div>
        <div class="weui-cell">
             <input type="submit" value="提交" id="btnsubmit"  class="weui-btn weui-btn_primary" />
        </div>
    </div></section></form>
@include('wechat.layouts.footer')
<script>
$(function () {
    /* form */
    // 约定正则
    var regexp = {
        regexp: {
            IDNUM: /(?:^\d{15}$)|(?:^\d{18}$)|^\d{17}[\dXx]$/
        }
    };
    $("#btnsubmit").click(function ()
    {
        $name=$("#name").val();
        $num=$("#cardNo").val();
        $tel=$("#phone").val();
        $code=$.trim($("#valicode").val());
        weui.form.validate('#form1', function(error){
            if (!error) {
                if($code==""){weui.toast("请输入验证码",3000);return;}
                $.ajax({
                    url:"{{route('authorization.store')}}",
                    type:'post',
                    datatype:"text",
                    data:{'name':$name,'cardNo':$num,'phone':$tel,'telcode':$code,'_token':'{{csrf_token()}}'},
                    success:function (data) {
                        if(data=="认证成功")
                        {
                            weui.confirm('您已授权成功,是否立即查询', function(){ self.location.href='{{route('credit.apply')}}'; }, function(){ console.log('no') });
                        }
                        else  weui.toast(data, 3000);
                    },
                    error:function () {
                      alert('系统服务出错');
                    }
                });
            }
            else
            weui.topTips(error);
            },regexp);

    });
   $("#code").click(function () {
       $name=$("#name").val();
       $num=$("#cardNo").val();
       $tel=$("#phone").val();
       weui.form.validate('#form1', function(error){
           if (!error) {
               $.ajax({
                   url:"{{route('validate.code')}}",
                   type:'get',
                   datatype:"text",
                   data:{'name':$name,'cardNo':$num,'phone':$tel},
                   success:function(data){
                       weui.toast(data, 3000);
                   }
               });
           }
           else
               weui.topTips(error);
       },regexp);
   }); 
});
</script>
</body>
</html>