@include('wechat.layouts.header')
<body>
<section class="qyc_container">
    <div class="weui-tab__panel">
        <div class="headTop">
            <a href="javascript:history.go(-1)" class="back"><i class="iconBack"></i></a><span>个人信用报告</span><a class="more"><i class="iconDian"></i><i class="iconDian"></i><i class="iconDian"></i></a>
        </div>
        <div class="weui-cell" style="background-color:#616773;position:inherit;border-top:0.01em solid #a2a4a8;color: white;">
            <div class="weui-cell__hd"><label class="weui-label">报告编号：</label></div>
            <div class="weui-cell__bd">
                2019012111235465
            </div>
        </div>
        <div class="rp_person">
            <div class="weui-cell border_none">
                <div class="weui-cell__hd"><label class="weui-label">姓&nbsp;名&nbsp;：</label></div>
                <div class="weui-cell__bd">
                    黄园林
                </div>
            </div>
            <div class="weui-cell border_none">
                <div class="weui-cell__hd"><label class="weui-label">证件号：</label></div>
                <div class="weui-cell__bd">
                    340825*****5465
                </div>
            </div>
        </div>
        <div class="report white-bgcolor">
            <div class="weui-cells__title rp_head" ><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp;手机检测</span></div>
            <div class="weui-cell" style="color: #666666;" >
                <div class="weui-cell__hd"><label class="weui-label">手机在网状态：</label></div>
                <div class="weui-cell__bd">
                    不在网
                </div>
                <div class="weui-cell__hd"><label class="weui-label">运营商：</label></div>
                <div class="weui-cell__bd">
                    移动
                </div>
            </div>
            <div class="weui-cell" style="color: #666666;">
                <div class="weui-cell__hd">手机所属地：</div>
                <div class="weui-cell__bd">
                    安徽&nbsp;&nbsp;合肥
                </div>
            </div>
            <div class="weui-cell" style="color: #666666;">
                <div class="weui-cell__hd">近三个月平均消费：</div>
                <div class="weui-cell__bd">
                    233-600
                </div>
            </div>
        </div>
        <div class="report white-bgcolor">
            <div class="weui-cells__title rp_head"><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp;车辆检测</span></div>
            <div class="weui-cell" style="color: #666666;" >
                <div class="weui-cell__hd">车牌号：</div>
                <div class="weui-cell__bd">
                    皖A.3N355
                </div>
                <div class="weui-cell__hd">车身颜色：</div>
                <div class="weui-cell__bd">
                    白
                </div>
            </div>
            <div class="weui-cell" style="color: #666666;" >
                <div class="weui-cell__hd">车架号：</div>
                <div class="weui-cell__bd">
                    皖5555
                </div>
                <div class="weui-cell__hd"><label class="weui-label">发动机号：</label></div>
                <div class="weui-cell__bd">
                    496560655648
                </div>
            </div>
            <div class="weui-cell" style="color: #666666;">
                <div class="weui-cell__hd">手机所属地：</div>
                <div class="weui-cell__bd">
                    安徽&nbsp;&nbsp;合肥
                </div>
            </div>
            <div class="weui-cell" style="color: #666666;">
                <div class="weui-cell__hd">近三个月平均消费：</div>
                <div class="weui-cell__bd">
                    233-600
                </div>
            </div>
        </div>
    </div></section>
@include('wechat.layouts.footer')
</body>
</html>