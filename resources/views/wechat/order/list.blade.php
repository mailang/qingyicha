@include('wechat.layouts.header')
<body class="white-bgcolor">
<section class="qyc_container">
    <div class="page__bd">
        <div class="headTop">
            <a href="javascript:history.go(-1)" class="back"><i class="iconBack"></i></a><span>我的订单</span><a class="more"><i class="iconDian"></i><i class="iconDian"></i><i class="iconDian"></i></a>
        </div>
        <div class="weui-tab">
            <div class="weui-navbar">
                <div class="weui-navbar__item weui-bar__item_on">
                    全部
                </div>
                <div class="weui-navbar__item">
                    待付款
                </div>
                <div class="weui-navbar__item">
                    已查询
                </div>
                <div class="weui-navbar__item">
                    已过期
                </div>
            </div>
            <div class="weui-tab__panel">
                   @foreach($orderlist as $order)
                    <div class="order_zhifu">实付款:<font class="font_red">¥{{$order->total_fee}}</font></div>
                       <div style="border_bottom:0.01em solid #eee;">
                        <div class="weui-cells"><div class="weui-cell weui-cell_access order_list">
                        <div class="weui-cell__hd"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC4AAAAuCAMAAABgZ9sFAAAAVFBMVEXx8fHMzMzr6+vn5+fv7+/t7e3d3d2+vr7W1tbHx8eysrKdnZ3p6enk5OTR0dG7u7u3t7ejo6PY2Njh4eHf39/T09PExMSvr6+goKCqqqqnp6e4uLgcLY/OAAAAnklEQVRIx+3RSRLDIAxE0QYhAbGZPNu5/z0zrXHiqiz5W72FqhqtVuuXAl3iOV7iPV/iSsAqZa9BS7YOmMXnNNX4TWGxRMn3R6SxRNgy0bzXOW8EBO8SAClsPdB3psqlvG+Lw7ONXg/pTld52BjgSSkA3PV2OOemjIDcZQWgVvONw60q7sIpR38EnHPSMDQ4MjDjLPozhAkGrVbr/z0ANjAF4AcbXmYAAAAASUVORK5CYII=" alt="" style="width:20px;margin-right:5px;display:block"></div>
                        <div class="weui-cell__bd">
                            <p>{{$order->pro_name}}</p>
                        </div>
                        <a  href="javascript:;"><div class="weui-cell__ft"></div>  </a>
                    </div>
                    <div class="order_zhifu">实付款:<font class="font_red">¥{{$order->total_fee}}</font></div>
                        </div>
                </div>
                  @endforeach
            </div>
        </div>
    </div></section>
@include('wechat.layouts.footer')
</body>
</html>