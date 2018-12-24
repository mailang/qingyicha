@include('admin.layouts.header')
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 系统管理 <span class="c-gray en">&gt;</span> 栏目管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" href="javascript:;" onclick="permission_add('添加角色','{{route('permissions.add')}}','800')"><i class="Hui-iconfont">&#xe600;</i> 添加栏目</a> </span> <span class="r">共有数据：<strong>54</strong> 条</span> </div>
    <table class="table table-border table-bordered table-hover table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="6">栏目管理</th>
        </tr>
        <tr class="text-c">
            <th width="25"><input type="checkbox" value="" name=""></th>
            <th width="40">ID</th>
            <th width="200">栏目名</th>
            <th width="200">链接</th>
            <th width="300">描述</th>
            <th width="70">操作</th>
        </tr>
        </thead>
        <tbody>
       @foreach($permissions as $item)
        <tr class="text-c">
            <td><input type="checkbox" value="" name=""></td>
            <td>{{$item->id}}</td>
            <td><a href="{{route('permissions.child',$item->id)}}"> {{$item->name}}</a></td>
            <td>{{$item->url}}</td>
            <td>{{$item->description}}</td>
            <td class="f-14">
                <a title="编辑" href="javascript:;" onclick="permission_edit('栏目编辑','{{route('permissions.add',$item->id)}}','3')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                <a title="删除" href="javascript:;" onclick="permission_del(this,'{{$item->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
        </tr>
       @endforeach
        </tbody>
    </table>
</div>
@include('admin.layouts.footer')
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
    /*管理员-角色-添加*/
    function permission_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*管理员-角色-编辑*/
    function permission_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
    /*管理员-角色-删除*/
    function permission_del(obj,id){
        layer.confirm('子栏目也会删除，确认要删除吗？',function(index){
            $.ajax({
                type: 'get',
                url: '/admin/permissions/delete/'+id,
                dataType: 'text',
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg(data,{icon:1,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }
</script>
</body>
</html>