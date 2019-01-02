@include('admin.layouts.header')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.treegrid.min.css')}}"/>
<link href="{{asset('css/bootstrap-table.min.css')}}" rel="stylesheet">
<script type="text/javascript" src="{{asset('js/jquery.treegrid.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-table.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-table-treegrid.min.js')}}"></script>
<body>
<form action="{{route('menu.update')}}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 微信管理 <span class="c-gray en">&gt;</span> 菜单管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div style="color: red;font-size: 12px; padding-left: 18px;"> 温馨提示：添加修改菜单栏目后需要点击同步微信，公众号栏目才会更新
        <br> 1、菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。
        <br> 2、如果存在二级菜单，二级菜单个数至少有一个,否则微信菜单会更新失败
        <br> 3、一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。
    </div>
    <div class="page-container" style=" text-align: center">
        <div class="cl pd-5 bg-1 bk-gray" style="text-align: left;">
            <span >  <a class="btn btn-primary radius" href="javascript:;" onclick="wemenu_add('添加菜单','/admin/menu/add','800')"><i class="Hui-iconfont"></i> 添加菜单</a> </span>
            <span >  <a class="btn btn-primary radius" href="javascript:;" onclick="push_menu()"> 同步到微信</a> </span>
        </div>
        <table id="table"></table>

    </div>
    <script>
        var $table = $('#table');
        function push_menu() {
            $.ajax({
               type:'get',
               url:'{{route('menu.push')}}',
                dataType:'text',
                success: function(data){
                    layer.msg(data,{icon:1,time:4000});
                },
                error:function(data) {
                    layer.msg(data);
                }
            });
        }
        $(function () {
            $table.bootstrapTable({
                url:'{{route('menu.data')}}',
                striped: true,
                sidePagination: 'server',
                idField: 'id',
                columns: [
                    {
                        field: 'id',
                        title: 'id'
                    },
                    {
                        field: 'name',
                        title: '名称'
                    },
                    {
                        field: 'type',
                        title: '类型'
                    },
                    {
                        field: 'url',
                        title: '链接'
                    },
                    {
                        field: 'key',
                        title: 'KEY标识符'
                    },
                    {
                        field: 'media_id',
                        title: 'media_id'
                    },
                    {
                        field: 'appid',
                        title: '小程序id'
                    },
                    {
                        field: 'pagepath',
                        title: '小程序路径'
                    },
                    {
                        field: 'enable',
                        title: '可用状态',
                        formatter:'enableFormatter'
                    },
                    { field:'button', title:'操作', events:'operateEvents', formatter:'Editor'}
                ],
                treeShowField: 'name',
                parentIdField: 'pid',
                onLoadSuccess: function(data) {
                    $table.treegrid({
                        treeColumn: 1,
                        onChange: function() {
                            $table.bootstrapTable('resetWidth')
                        }
                    })
                }
            })
        });
        function Editor(value,row,index) { return[ '<button id="TableEditor"  type="button" class="btn btn-default">编辑</button>&nbsp;&nbsp;', '<button id="TableDelete"  type="button" class="btn btn-default">删除</button>'].join("") }
        window.operateEvents={ "click #TableEditor":function (e,value,row,index){ var id=$(this).parent().siblings("td:first").html(); wemenu_edit('菜单编辑','/admin/menu/add/'+id,id,800) }, "click #TableDelete":function (e,value,row,index){wemenu_del($(this).parent().siblings("td:first").html(),this);} }
        function enableFormatter(value, row, index) {

            if (value === 1) {
                return '<span class="label label-success">可用</span>'
            }
            return '<span class="label label-default">禁用</span>'
        }
        /*菜单-编辑*/
        function wemenu_edit(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
        function wemenu_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        function wemenu_del(id,obj){
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'get',
                    url: '/admin/menu/delete/'+id,
                    dataType: 'text',
                    success: function(data){
                        layer.msg(data,{icon:1,time:1000});
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
                $(obj).parent().parent().remove();
            });
        }
    </script>
</form>
@include('admin.layouts.footer')
</body>
</html>