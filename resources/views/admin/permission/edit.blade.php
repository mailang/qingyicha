@include('admin.layouts.header')
<body>
<article class="page-container">
    <form action="{{route('roles.store')}}" method="post" class="form form-horizontal" id="permissions-edit">
        <input type="hidden"  name="_token" value="{{ csrf_token() }}" />
        <input type="hidden"  name="id" value="{{$per->id}}" />
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>栏目名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$per->name}}" placeholder="" id="name" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">
                <span class="c-red">*</span>
                上级栏目：</label>
            <div class="formControls col-xs-8 col-sm-9">
						<span class="select-box">
						<select class="select valid" id="sel_Sub" name="pid" onchange="SetSubID(this);" aria-invalid="false">
						@if($per->pid==-1)<option value="-1">顶级分类</option>
                            @else<option value="-1">顶级分类</option>
                            @foreach($permission as $item)
                                <option value="{{$item->id}}" @if($per->pid==$item->id) selected @endif >{{$item->name}}</option>
                            @endforeach
                            @endif
						</select>
						</span>
            </div>
            <div class="col-3">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>栏目链接：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$per->url}}" placeholder="" id="url" name="url">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">备注：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea id="description" name="description"  cols="" rows="" class="textarea valid" dragonfly="true" >

                    {{$per->description}}
                </textarea>
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
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
<script type="text/javascript">
    $(function(){
        $("#permissions-edit").validate({
            rules:{
                name:{
                    required:true
                }
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type: 'post',
                    datatype:"text",
                    url: "{{route('permissions.update')}}" ,
                    success: function(data){
                        layer.msg(data,{icon:1,time:2000},function () {
                            toparent();
                        });
                    },
                    error: function(XmlHttpRequest, textStatus, errorThrown){
                        layer.msg('error!',{icon:1,time:2000});
                    }
                });
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