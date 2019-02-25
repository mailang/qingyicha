@include('wechat.layouts.header')
<body class="white-bgcolor">
@include('wechat.layouts.footer')
<script>
    $(function () {
        var loading = weui.loading('查询中...');
        $.ajax({
            url:'{{route('apply.store')}}',
            data:{"order_id":"{{$order_id}}"},
            type:"post",
            datatype:'text',
            success:function (data) {
                loading.hide();
                location.href="/weixin/apply/success/{{$order_id}}";
                //weui.toast('提交成功', 3000);
            },
            error:function () {
                weui.toast('服务出错', 3000);
            }
        });
    });
</script>
</body>
</html>