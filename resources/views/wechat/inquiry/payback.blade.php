@include('wechat.layouts.header')
<body class="white-bgcolor">
@include('wechat.layouts.footer')
<script>
    $(function () {
        var loading = weui.loading('查询中...');
        $.ajax({
            url:'{{route('inquiry.check',$user_interface->id)}}',
            type:"get",
            datatype:'json',
            success:function (data) {
                loading.hide();
               if (data!="")
               {
                   $("body").append(data);
               }
               else {
                   var type="{{$user_interface->interface_id}}";
                   if (type==3)
                       $url="/weixin/person/{{$user_interface->order_id}}/{{$user_interface->name}}/1";
                   else $url="/weixin/enterprise/{{$user_interface->order_id}}/{{$user_interface->name}}/1";
                   location.href=$url;
                   //weui.toast('提交成功', 3000);
               }
            },
            error:function () {
                alert("{{route('inquiry.check',$user_interface->id)}}");
                weui.toast('服务出错', 3000);
            }
        });
    });
</script>
</body>
</html>