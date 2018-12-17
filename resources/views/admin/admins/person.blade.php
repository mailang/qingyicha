@include('admin.layouts.header')
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-admin-add">
        <input type="hidden"  name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" id="uid" name="id" value="{{$admins->id}}">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <label>{{$admins->username}} </label>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>真实姓名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <label>{{$admins->realname}}</label>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>初始密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" autocomplete="off" value="" placeholder="密码" id="password" name="password">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" autocomplete="off"  placeholder="确认新密码" id="password2" name="password2">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户状态：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
              <label> @if($admins->isenable==1) 启用 @else 禁用  @endif </label>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">角色：</label>
            <div class="formControls col-xs-8 col-sm-9">
			<label> {{$roles->name}}</label>
			 </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>

@include('admin.layouts.footer')
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
<script type="text/javascript">
    $(function(){
        $("#form-admin-add").validate({
            rules:{
                password:{
                    required:true,
                },
                password2:{
                    required:true,
                    equalTo: "#password"
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form) {
                $("#form-admin-add").ajaxSubmit({
                    type: 'post',
                    datatype: "text",
                    url: "/admin/admins/update/pwd",
                    success: function (data) {
                        layer.msg(data, {icon: 1, time: 2000}, function () {
                            toparent();
                        });
                    },
                    error: function (XmlHttpRequest, textStatus, errorThrown) {
                        layer.msg('error!', {icon: 1, time: 1000});
                    }
                });
            }
        });
    });
    function toparent() {
        parent.location.href="{{route('admin.logout')}}";
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        parent.location.reload();
    }
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>