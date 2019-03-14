@include('wechat.layouts.header')
<body class="white-bgcolor">
<section class="qyc_container">
    <div class="page__bd">
        <div class="headTop">
            <a href="javascript:history.go(-1)" class="back"><i class="iconBack"></i></a><span>企业涉诉详情</span><a class="more"><i class="iconDian"></i><i class="iconDian"></i><i class="iconDian"></i></a>
        </div>
        <div class="weui-cell" style="border-bottom: 1px solid #eee;">
            <div>
                <span style="display: block;color: green; font-size: 15px;">企业名:{{$report["name"]}}</span>
            </div>
        </div>
        @if($report["pageData"]!=null)
            @foreach($report["pageData"] as $item)
                @switch(strtoupper($item->dataType))
                    @case("KTGG")
                    <div class="weui-cell font14">
                        <div>
                        <span><label>涉诉类别：</label></span>
                        <span>开庭公告</span>
                        <span><label>当事人：</label></span>
                        <span>{{$item->party}}</span>
                    </div>
                    <div>
                        <span><label>案由：</label></span>
                        <span>{{$item->caseCause}}</span>
                    </div>
                    <div>
                        <span><label>法庭：</label></span>
                        <span>{{$item->courtroom}}</span>
                    </div>
                    <div>
                        <span><label>内容：</label></span>
                        <span>{{$item->content}}</span>
                    </div>
                    <div>
                        <span><label>法院名称：</label></span>
                        <span>{{$item->court}}</span>
                    </div>
                    <div>
                        <span><label>开庭时间：</label></span>
                        <span>{{$item->time}}</span>
                    </div>
                   </div>
                    @break;
                    @case("CPWS")
                    <div class="weui-cell font14">
                    <div>
                        <span><label>涉诉类别：</label></span>
                        <span>裁判文书</span>
                        <span><label>审结时间：</label></span>
                        <span>{{$item->time }}</span>
                    </div>
                        <div>
                        <span><label>案件类型:</label> </span>
                        <span>{{$item->caseType}}</span>
                        <span><label>案件号:</label> </span>
                        <span>{{$item->caseNO}}</span>
                        </div>
                    <div>
                        <span><label>内容：</label></span>
                        <span>{{$item->content}}</span>
                    </div>
                    <div>
                        <span><label>法院名称：</label></span>
                        <span>{{$item->court}}</span>
                    </div>
                    <div>
                        <span><label>开庭时间：</label></span>
                        <span>{{$item->time}}</span>
                    </div>
                    </div>
                    @break;
                    @case("ZXGG")
                    <div class="weui-cell font14">
                    <div>
                        <span><label>涉诉类别：</label></span>
                        <span>执行公告</span>
                        <span><label>立案时间：</label></span>
                        <span>{{$item->time }}</span>
                    </div>
                    <div>
                        <span><label>被执行人：</label></span>
                        <span>{{$item->name}}</span>
                    </div>
                    <div>
                        <span><label>身份证或组织机构：</label></span>
                        <span>{{$item->identificationNO }}</span>
                    </div>
                    <div>
                        <span><label>执行标的：</label></span>
                        <span>{{$item->executionTarget}}元</span>
                    </div>
                    <div>
                        <span><label>内容：</label></span>
                        <span>{{$item->content}}</span>
                    </div>
                    <div>
                        <span><label>法院名称：</label></span>
                        <span>{{$item->court}}</span>
                     </div>
                   </div>
                    @break;
                    @case("SXGG")
                    <div class="weui-cell font14" >
                        <span><label>涉诉类别：</label></span>
                        <span>失信公告</span>
                        <span><label>立案时间：</label></span>
                        <span>{{$item->time }}</span>
                    </div>
                    <div>
                        <span><label>被执行人：</label></span>
                        <span>{{$item->name}}</span>
                        <span><label>性别：</label></span>
                        <span>{{$item->gender}}</span>
                    </div>
                    <div>
                        <span><label>年龄：</label></span>
                        <span>{{$item->age}}</span>
                        <span><label>省份：</label></span>
                        <span>{{$item->province}}</span>
                    </div>
                    <div>
                        <span><label>身份证或组织机构：</label></span>
                        <span>{{$item->identificationNO }}</span>
                    </div>
                    <div>
                        <span><label > 履行情况：</label></span>
                        <span>{{$item->implementationStatus}}</span>
                        <span><label > 依据案号 ：</label></span>
                        <span>{{$item->evidenceCode }}</span>
                    </div>
                    <div>
                        <span><label>执行依据单位 ：</label></span>
                        <span>{{$item->executableUnit }}</span>
                    </div>
                    <div>
                        <span><label> 具体情形 ：</label></span>
                        <span>{{$item->specificCircumstances}}</span>
                    </div>
                    <div>
                        <span><label> 法律确定义务 ：</label></span>
                        <span>{{$item->obligations }}</span>
                    </div>
                    <div>
                        <span><label>内容：</label></span>
                        <span>{{$item->content}}</span>
                    </div>
                    <div>
                        <span><label>法院名称：</label></span>
                        <span>{{$item->court}}</span>
                    </div>

                    @break;
                    @case("FYGG")
                    <div class="weui-cell font14" >
                        <span><label>涉诉类别：</label></span>
                        <span>法院公告</span>
                        <span ><label>发布时间：</label></span>
                        <span>{{$item->time }}</span>
                    </div>
                    <div>
                        <span><label>版面：</label></span>
                        <span>{{$item->layout}}</span>
                        <span><label>当事人：</label></span>
                        <span>{{$item->name }}</span>
                    </div>
                    <div>
                        <span><label>公告类型：</label></span>
                        <span>{{$item->announcementType}}</span>
                    </div>
                    <div>
                        <span><label>内容：</label></span>
                        <span>{{$item->content}}</span>
                    </div>
                    <div>
                        <span><label>法院名称：</label></span>
                        <span>{{$item->court}}</span>
                    </div>
                    @break;
                    @case("WDHM")
                    <div class="weui-cell font14" >
                        <span>
                        <span><label>涉诉类别：</label></span>
                        <span>网贷黑名单</span>
                        <span><label>贷款时间：</label></span>
                        <span>{{$item->time }}</span>
                    </span>
                    <div>
                        <span><label>姓名：</label></span>
                        <span>{{$item->name}}</span>
                        <span><label>性别：</label></span>
                        <span>{{$item->sex}}</span>
                    </div>
                    <div>
                        <span><label>数据来源:</label></span>
                        <span>{{$item->sourceName }}</span>
                    </div>
                    <div>
                        <span><label>本金/本息:</label></span>
                        <span>{{$item->principal}}</span>
                    </div>
                    <div>
                        <span><label>未还/罚息:</label></span>
                        <span>{{$item->penalty}}</span>
                    </div>
                    <div>
                        <span><label>已还金额:</label></span>
                        <span>{{$item->paid}}</span>
                    </div>
                    <div>
                        <span><label>内容：</label></span>
                        <span>{{$item->content}}</span>
                    </div>
                    <div>
                        <span><label>法院名称：</label></span>
                        <span>{{$item->court}}</span>
                    </div>
                    </div>
                    @break;
                    @case("AJLC")
                    <div class="weui-cell font14" >
                    <div>
                        <span><label>涉诉类别：</label></span>
                        <span>案件流程</span>
                        <span ><label>立案时间：</label></span>
                        <span>{{$item->time}}</span>
                    </div>
                        <div>
                        <span><label>当事人：</label></span>
                        <span>{{$item->name}}</span>
                    </div>
                    <div>
                        <span><label>案由：</label></span>
                        <span>{{$item->caseCause}}</span>
                    </div>
                    <div>
                        <span><label>内容：</label></span>
                        <span>{{$item->content}}</span>
                    </div>
                    <div>
                        <span><label>法院名称：</label></span>
                        <span>{{$item->court}}</span>
                    </div>
                     </div>
                    @break;
                    @case("BGT")
                   <div class="weui-cell font14">
                    <div>
                        <span><label>涉诉类别：</label></span>
                        <span>曝光台</span>
                        <span><label>立案时间：</label></span>
                        <span>{{$item->time}}</span>
                    </div>
                    <div>
                        <span><label>当事人：</label></span>
                        <span>{{$item->name}}</span>
                    </div>
                    <div>
                        <span ><label>提案人：</label></span>
                        <span>{{$item->proposer}}</span>
                    </div>
                    <div>
                        <span><label>内容：</label></span>
                        <span>{{$item->content}}</span>
                    </div>
                    <div>
                        <span><label>法院名称：</label></span>
                        <span>{{$item->court}}</span>
                    </div>
                 </div>
                    @break;
                @endswitch
            @endforeach
                <div class="font14">
                    <div class="pager-left">
                        <div class="pager-first"><a class="pager-nav">首页</a></div>
                        <div class="pager-pre"><a class="pager-nav">上一页</a></div>
                    </div>
                    <div class="pager-cen">1/120</div>
                    <div class="pager-right">
                        <div class="pager-next"><a class="pager-nav">下一页</a></div>
                        <div class="pager-end"><a class="pager-nav">尾页</a></div>
                    </div>
                </div>
        @else
            <div class="weui-cell">
                <div>未查询到相关涉诉记录</div>
            </div>
        @endif
    </div></section>
@include('wechat.layouts.footer')
</body>
</html>