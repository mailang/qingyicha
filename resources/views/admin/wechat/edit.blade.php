@include('admin.layouts.header')
<body>
<article class="page-container">
    <form  method="post" class="form form-horizontal" id="wemenu-add">
        <input type="hidden"  name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="id" id="id" value="{{$menu->id}}"/>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>菜单名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$menu->name}}" placeholder="" id="name" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>类型：</label>
            <div class="formControls col-xs-8 col-sm-9">
           <span class="select-box">
						<select class="select valid" id="type" name="type" aria-invalid="false" onchange="typeclick()">
                            @if($menu->pid==0&&$sub>0)
                                <option value="none"   @if($menu->type=="none") selected  @endif>--无-- {{$sub}}</option>
                                @else
                                <option value="none"   @if($menu->type=="none") selected  @endif>--无--</option>
                                <option value="view" @if($menu->type=="view") selected @endif>网页类型</option>
                                <option value="click" @if($menu->type=="click") selected @endif>点击类型</option>
                                <option value="miniprogram" @if($menu->type=="miniprogram") selected @endif>小程序类型</option>
                                <option value="media_id" @if($menu->type=="media_id") selected @endif>图片</option>
                                <option value="view_limited" @if($menu->type=="view_limited") selected @endif>图文消息</option>
                                <option value="scancode_waitmsg" @if($menu->type=="scancode_waitmsg") selected @endif>扫码带提示
                                <option value="scancode_push" @if($menu->type=="scancode_push") selected @endif>扫码推事件</option>
                                <option value="pic_sysphoto" @if($menu->type=="pic_sysphoto") selected @endif>系统拍照发图</option>
                                <option value="pic_weixin" @if($menu->type=="pic_weixin") selected @endif>微信相册发图</option>
                                <option value="pic_photo_or_album" @if($menu->type=="pic_photo_or_album") selected @endif>拍照或者相册发图</option>
                                <option value="location_select" @if($menu->type=="location_select") selected @endif>发送位置</option>
                           @endif
                        </select>
						</span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">
                <span class="c-red">*</span>
                上级菜单：</label>
            <div class="formControls col-xs-8 col-sm-9">
                     <span class="select-box">
                     {{$pname}}
                     </span>
            </div>
        </div>
        <!--点击类必须项-->
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">菜单KEY值：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$menu->key}}"  placeholder="" id="key" name="key"  @if($menu->key=='') disabled="disabled" @endif >
            </div>
        </div>
        <!--view、miniprogram类型必须-->
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>url：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$menu->url}}" placeholder="" id="url" name="url"  @if($menu->url=='') disabled="disabled" @endif >
            </div>
        </div>
        <!--media_id类型和view_limited类型必须-->
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">media_id：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$menu->media_id}}" placeholder="" id="media_id" name="media_id" @if($menu->media_id=='') disabled="disabled" @endif>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">小程序appid：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$menu->appid}}" placeholder="" id="appid" name="appid" @if($menu->appid=='') disabled="disabled" @endif>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">小程序pagepath：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$menu->pagepath}}" placeholder="" id="pagepath" name="pagepath" @if($menu->pagepath=='') disabled="disabled" @endif>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">菜单可用状态 ：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box">
                    <input name="enable" type="radio" value="1" id="enable"  @if($menu->enable==1) checked @endif >
                    <label for="enable">启用</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="forbid" value="0" name="enable" @if($menu->enable==0) checked @endif>
                    <label for="forbid">禁用</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
            </div>
        </div>
    </form>
</article>

@include('admin.layouts.footer')
<!--请在下方写此页面业务相关的脚本-->
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
<script type="text/javascript">
    function typeclick() {
        var slctype= $("#type").val();
        switch (slctype){
            case "none":$("input[type='text']").prop("disabled","disabled");$("#name").removeProp("disabled");break;
            case "view":$("input[type='text']").prop("disabled","disabled");$("#url,#name").removeProp("disabled");break;
            case "click":$("input[type='text']").prop("disabled","disabled");$("#key,#name").removeProp("disabled");break;
            case "miniprogram":$("input[type='text']").prop("disabled","disabled");$("#appid,#name,#url,#pagepath").removeProp("disabled");break;
            case "media_id":$("input[type='text']").prop("disabled","disabled");$("#name,#media_id").removeProp("disabled");break;
            case "view_limited":$("input[type='text']").prop("disabled","disabled");$("#name,#media_id").removeProp("disabled");break;
            default:$("input[type='text']").prop("disabled","disabled");$("#name,#key").removeProp("disabled");break;
        }
    }
    $(function(){
        $("#wemenu-add").validate({
            rules:{
                name:{
                    required:true
                },
                type:{required:true},
                pid:{required:true}
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                var slctype= $("#type").val();
                var bool=true;
                switch (slctype){
                    case "none": if($.trim($("#name").val())==""){ layer.msg("name不能为空");bool=false; }break;
                    case "view": if($.trim($("#url").val())=="") {layer.msg("url不能为空");bool=false;} break;
                    case "click": if($.trim($("#key").val())=="") { layer.msg("key不能为空");bool=false;}break;
                    case "miniprogram":if($.trim($("#appid").val())==""||$.trim($("#url").val())==""||$.trim($("#pagepath").val())=="") { layer.msg("url,appid,pagepath均不能为空");bool=false;}break;
                    case "media_id":if($.trim($("#media_id").val())=="")  {layer.msg("media_id不能为空");bool=false;}break;
                    case "view_limited":if($.trim($("#media_id").val())==""){  layer.msg("media_id不能为空");bool=false;}break;
                    default:if($.trim($("#key").val())=="") { layer.msg("key不能为空");}break;
                }if (bool) {
                        $(form).ajaxSubmit({
                        type: 'post',
                        datatype:"text",
                        url: "{{route('menu.update')}}" ,
                        success: function(data){
                            if(data=="操作成功") layer.msg(data,{icon:1,time:2000},function () {toparent();      });
                            else  layer.msg(data,{icon:1,time:2000});
                        },
                        error: function(XmlHttpRequest, textStatus, errorThrown){
                            layer.msg('error!',{icon:1,time:2000});
                        }
                    });
                }

            }
        });
    });
    function toparent() {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        parent.location.reload();
    }
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>