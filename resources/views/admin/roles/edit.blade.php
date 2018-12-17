@extends('admin.layouts.header')
<body>
<article class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
        <input type="hidden"  name="_token" value="{{ csrf_token() }}" />
        <input type="hidden"  name="id" value="{{ $roles->id }}" />
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$roles->name}}" placeholder="" id="name" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">备注：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$roles->description}}" placeholder="" id="description" name="description">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">网站角色：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <dl class="permission-list">
                    <dt>
                        <label>
                            <input type="checkbox" value="" name="user-Character-0" id="user-Character-0">
                            全部</label>
                    </dt>
                    <dd>
                        <?php $roots=$permissions->where('pid',"-1"); ?>
                        @foreach($roots as $key=>$root)
                            <dl class="cl permission-list2">
                                <dt>
                                    <label class="">
                                        <input type="checkbox" @if(in_array($root->id,$permitids)) checked @endif value="{{$root->id}}" name="permissions[]">
                                        {{$root->name}}</label>
                                </dt>
                                <dd>
                                    <?php $childs=$permissions->where('pid',$root->id); ?>
                                    @foreach($childs as $child)
                                        <label class="">
                                            <input type="checkbox" value="{{$child->id}}" @if(in_array($root->id,$permitids)) checked @endif name="permissions[]" id="user-Character-0-0-0">
                                            {{$child->name}}</label>
                                    @endforeach
                                </dd>
                            </dl>
                        @endforeach
                    </dd>
                </dl>
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
        $(".permission-list dt input:checkbox").click(function(){
            $(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
        });
        $(".permission-list2 dd input:checkbox").click(function(){
            var l =$(this).parent().parent().find("input:checked").length;
            var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
            if($(this).prop("checked")){
                $(this).closest("dl").find("dt input:checkbox").prop("checked",true);
                $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
            }
            else{
                if(l==0){
                    $(this).closest("dl").find("dt input:checkbox").prop("checked",false);
                }
                if(l2==0){
                    $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
                }
            }
        });

        $("#form-admin-role-add").validate({
            rules:{
                roleName:{
                    required:true,
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type: 'post',
                    datatype:"text",
                    url: "{{route('roles.update')}}" ,
                    success: function(data){
                        layer.msg(data,{icon:1,time:2000},function () {
                            toparent();
                        });
                    },
                    error: function(XmlHttpRequest, textStatus, errorThrown){
                        layer.msg('error!',{icon:1,time:1000});
                    }
                });
            }
        });
    });
    function toparent() {
        var index = parent.layer.getFrameIndex(window.name);
        parent.location.reload();
        parent.layer.close(index);
    }
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>