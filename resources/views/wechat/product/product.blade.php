@include('wechat.layouts.header')
<body class="white-bgcolor">
<section class="qyc_container">
    <div class="headTop">
        <a href="javascript:history.go(-1)" class="back"><i class="iconBack"></i></a><span>{{$product->pro_name}}</span><a class="more"><i class="iconDian"></i><i class="iconDian"></i><i class="iconDian"></i></a>
    </div>
    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">付款金额</label>
                <em class="weui-form-preview__value">¥{{$product->price}}</em>
            </div>
        </div>
        <div class="weui-cell white-bgcolor">
            <div class="weui-cell__hd" style="color: #999;">
                <label class="weui-label">描述</label>
            </div>
            <div class="weui-cell__bd white-bgcolor">
               {{$product->description}}
            </div>
        </div>
        <div class="weui-form-preview__ft">
            <a href="{{route('credit.apply',$product->id)}}" class="weui-btn weui-btn_primary">下一步</a>
        </div>
    </div>
</section>
@include('wechat.layouts.footer')
</body>
</html>