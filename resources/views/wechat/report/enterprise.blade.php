@include('wechat.layouts.header')
<body class="white-bgcolor">
<section class="qyc_container">
    <div class="page__bd">
        <div class="headTop">
            <a href="javascript:history.go(-1)" class="back"><i class="iconBack"></i></a><span>企业详情</span><a class="more"><i class="iconDian"></i><i class="iconDian"></i><i class="iconDian"></i></a>
        </div>
        @if(isset($enterprise['enterpriseHJ'])&&$enterprise['enterpriseHJ']!=null)
        <div class="weui-cell" style="border-bottom: 1px solid #eee;">
            <div>
                <span style="display: block;color: green; font-size: 15px;">企业：{{$enterprise['enterpriseHJ']["data"]->name}}</span>
            </div>
        </div>
        <div class="weui-cell ">
            <div class="weui-cell__hd"><label class="weui-label">法人类型：</label></div>
            <div class="weui-cell__bd font12">
                {{$enterprise['enterpriseHJ']["data"]->type==1?"人":"企业"}}
            </div>
            <div class="weui-cell__hd"><label class="weui-label">经营时间：</label></div>
            <div class="weui-cell__bd font12">
                {{date('Y-m-d',strtotime($enterprise['enterpriseHJ']["data"]->fromTime))}}
            </div>
        </div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="weui-label font12">行业评分：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->categoryScore}}
                </div>
                <div class="weui-cell__hd"><label class="weui-label font12">企业评分：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->percentileScore}}
                </div>
            </div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="weui-label font12">注册号：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->regNumber}}
                </div></div>
                <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="weui-label font12">网址：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->websiteList}}
                </div></div>
                <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="weui-label font12">邮箱：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->email}}
                </div></div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="weui-label font12">注册资金：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->regCapital}}
                </div></div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="weui-label font12">登记机关：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->regInstitute}}
                </div></div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="weui-label font12">注册地址：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->regLocation}}
                </div></div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="weui-label font12">行业：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->industry}}
                </div></div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="weui-label font12">核准机构：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->orgApprovedInstitute}}
                </div>
                <div class="weui-cell__hd"><label class="weui-label font12">核准时间：</label></div>
                <div class="weui-cell__bd font12">
                    {{date('Y-m-d',strtotime($enterprise['enterpriseHJ']["data"]->approvedTime))}}
                </div>
            </div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="font12">纳税人识别号：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->taxNumber}}
                </div></div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="font12">经营范围：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->businessScope}}
                </div></div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="font12">英文名：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->property3}}
                </div></div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="font12">组织机构代码：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->orgNumber}}
                </div></div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="font12">开业时间：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->estiblishTime}}
                </div></div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="font12">经营状态：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->regStatus}}
                </div></div>
            <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="font12">法人：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->legalPersonName}}
                </div>
                <div class="weui-cell__hd"><label class="font12">联系方式：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->phoneNumber}}
                </div></div>
                <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="font12">公司类型：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->companyOrgType}}
                </div></div>
               <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="font12">社会统一信用代码：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->creditCode }}
                </div></div>
               <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="font12">经营结束时间：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->toTime }}
                </div></div>
                <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="font12">来源：</label></div>
                <div class="weui-cell__bd font12">
                    {{$enterprise['enterpriseHJ']["data"]->sourceFlag }}
                </div></div>
            @else
            <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                <div class="weui-cell__bd font12">未查询到详细的企业信息</div>
            </div>
        @endif
    </div></section>
@include('wechat.layouts.footer')
</body>
</html>
<!-- 查看企业的详细信息-->