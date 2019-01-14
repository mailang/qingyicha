@include('wechat.layouts.header')
<body>
<section class="qyc_container white-bgcolor">
    <div class="weui-tab__panel">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">真实姓名</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" placeholder="请输入文本">
            </div>
        </div>
        <div class="weui-cell"> <div class="weui-cell__hd">
                <label class="weui-label">身份证号码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" required="" pattern="REG_IDNUM" maxlength="18" placeholder="输入你的身份证号码" emptytips="请输入身份证号码" notmatchtips="请输入正确的身份证号码">
            </div>
            <div class="weui-cell__ft"> <i class="weui-icon-warn"></i> </div> </div>

        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd">
                <label class="weui-label">手机号</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="tel" placeholder="请输入手机号">
            </div>
            <div class="weui-cell__ft">
                <button class="weui-vcode-btn">获取验证码</button>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" pattern="[0-9][A-Z]*"  placeholder="请输入验证码">
            </div>
        </div>
        <div class="weui-cell">
            <a href="javascript:void(0);" class="weui-btn weui-btn_primary">提交</a>
        </div>
    </div></section>
@include('wechat.layouts.footer')
</body>
</html>