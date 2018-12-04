<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{asset('lib/html5shiv.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib/respond.min.js')}}"></script>
    <![endif]-->
    <link href="{{asset('static/h-ui/css/H-ui.min.css')}}" rel="stylesheet">
    <link href="{{asset('static/h-ui.admin/css/H-ui.login.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('lib/Hui-iconfont/1.0.8/iconfont.css')}}" rel="stylesheet" type="text/css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="{{asset('lib/DD_belatedPNG_0.0.8a-min.js')}}" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>管理系统后台登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="header"></div>
<div class="loginWraper">
    <div id="loginform" class="loginBox">
        <form id="form1" class="form form-horizontal" action="/admin/login" method="post">
            {{ csrf_field() }}
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                <div class="formControls col-xs-8">
                    <input id="username" name="username" type="text" placeholder="用户名" class="input-text size-L" autocomplete="off">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                <div class="formControls col-xs-8">
                    <input id="password" name="password" type="password" placeholder="密码" class="input-text size-L" autocomplete="off">
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input id="captcha" name="captcha" class="input-text size-L" type="text" placeholder="验证码" autocomplete="off"  value="" style="width:150px;">
                    <img src="{{captcha_src()}}" style="cursor: pointer"  onclick="this.src='{{captcha_src()}}'+Math.random()"> </div>
            </div>
            @if(count($errors)>0)
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li style="color: red">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;"  style="width:150px;">
              </div>
            </div>
        </form>
    </div>
</div>
<div class="footer">Copyright **管理系统后台</div>
<script type="text/javascript" src="{{asset('lib/jquery/1.9.1/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('static/h-ui/js/H-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/layer/2.4/layer.js')}}"></script>

<script>
    $('#form1').submit(function() {
        if($("input[name='username']").val()==''||$("input[name='password']").val()==''){layer.alert('用户名或密码不能为空');return false;}
        var verify = $(':text[name="captcha"]').val();
        if (verify == '') {
            layer.alert('请填写验证码');
            return false;
        }
    });
</script>
</body>
</html>