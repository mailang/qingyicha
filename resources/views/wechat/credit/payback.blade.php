@include('wechat.layouts.header')
<body class="white-bgcolor">
<script>
    $(function () {
        var loading = weui.loading('查询中...');
        $.ajax({
            url:'{{route('apply.store')}}',
            type:"post",
            datatype:'text',
            success:function (data) {
                loading.hide();
                location.href="/weixin/apply/success/"+$("#order_id").val();
                //weui.toast('提交成功', 3000);
            },
            error:function () {
                weui.toast('服务出错', 3000);
            }
        });
    });
</script>
@include('wechat.layouts.footer')
</body>
</html>