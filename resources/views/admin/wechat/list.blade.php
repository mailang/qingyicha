@include('admin.layouts.header')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.treegrid.min.css')}}"/>
<script type="text/javascript" src="{{asset('js/jquery.treegrid.min.js')}}"></script>
<body>
<form action="{{route('menu.update')}}" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 微信管理 <span class="c-gray en">&gt;</span> 菜单管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container" style=" text-align: center">
    <div class="row cl">
        <div class="formControls col-xs-8 col-sm-9">
             <textarea id="menu" name="menu" style="width:500px;" rows="40">
                 [
                 <?php
                     function arr($arr)
                         {
                         foreach($arr as $key=>$value)
                             {
                                 if(is_array($value))
                                    {
                                        if (preg_match('#[a-z]+#i',$key))
                                        echo  "\"".$key."\"=>\r\n";
                                        echo "  [";
                                        if(count($value)>0)
                                                arr($value);
                                        echo  "  ],\r\n";
                                    }
                                 else
                                     {
                                         if (preg_match('#[a-z]+#i',$key))
                                             echo "  \"".$key ."\"=>\"".$value."\",\r\n";

                                     }
                             }
                         }
                         arr($buttons);
                 ?>
                 ]

      </textarea>
        </div>
    </div>
    <div style="height: 5px;line-height: 5px"></div>
    <div class="row cl">
        <div class="formControls col-xs-8 col-sm-9">
            <button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
        </div>
    </div>
</div>
    <table id="table"></table>

    <script>
        var $table = $('#table')
        function mounted() {
            $table.bootstrapTable({
                url: 'json/treegrid.json',
                striped: true,
                sidePagination: 'server',
                idField: 'id',
                columns: [
                    {
                        field: 'ck',
                        checkbox: true
                    },
                    {
                        field: 'name',
                        title: '名称'
                    },
                    {
                        field: 'status',
                        title: '状态',
                        sortable: true,
                        align: 'center',
                        formatter: 'statusFormatter'
                    },
                    {
                        field: 'permissionValue',
                        title: '权限值'
                    }
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
        }
        function typeFormatter(value, row, index) {
            if (value === 'menu') {
                return '菜单'
            }
            if (value === 'button') {
                return '按钮'
            }
            if (value === 'api') {
                return '接口'
            }
            return '-'
        }
        function statusFormatter(value, row, index) {
            if (value === 1) {
                return '<span class="label label-success">正常</span>'
            }
            return '<span class="label label-default">锁定</span>'
        }
    </script>
</form>
@include('admin.layouts.footer')
</body>
</html>