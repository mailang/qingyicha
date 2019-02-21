@include('wechat.layouts.header')
<body>
<section class="qyc_container">
    <div class="weui-tab__panel">
        <div class="headTop">
            <a href="javascript:history.go(-1)" class="back"><i class="iconBack"></i></a><span>个人信用报告</span><a class="more"><i class="iconDian"></i><i class="iconDian"></i><i class="iconDian"></i></a>
        </div>
        <div class="weui-cell" style="background-color:#616773;position:inherit;border-top:0.01em solid #a2a4a8;color: white;">
            <div class="weui-cell__hd"><label class="weui-label">报告日期：</label></div>
            <div class="weui-cell__bd">
                {{$auth->time}}
            </div>
        </div>
        <div class="rp_person">
            <div class="weui-cell border_none">
                <div class="weui-cell__hd"><label class="weui-label">姓&nbsp;名&nbsp;：</label></div>
                <div class="weui-cell__bd">
                    {{$auth->name}}
                </div>
            </div>
            <div class="weui-cell border_none">
                <div class="weui-cell__hd"><label class="weui-label">证件号：</label></div>
                <div class="weui-cell__bd">
                    {{strlen($auth->cardNo)==15?substr_replace($auth->cardNo,"****",8,4):substr_replace($auth->cardNo,"****",10,4)}}

                </div>
            </div>
        </div>
        @if(isset($report["phone"]))
        <div class="report white-bgcolor">
            <div class="weui-cells__title rp_head" ><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp;手机检测</span></div>
               @if($report["phone"]["state"]==0)
                <div class="weui-cell" style="color: #666666;" >
                    <div class="weui-cell__hd">{{$report["phone"]["msg"]}}</div>
                </div>
                @else
                <div class="weui-cell" style="color: #666666;" >
                <div class="weui-cell__hd"><label class="weui-label">手机在网状态：</label></div>
                <div class="weui-cell__bd">
                    {{$report["phone"]["status"]}}
                </div>
                <div class="weui-cell__hd"><label class="weui-label">运营商：</label></div>
                <div class="weui-cell__bd">
                    {{$report["phone"]["operators"]}}
                </div>
                </div>
                @endif
        </div>
        @endif
        @if(isset($report["multipleLoan"]))
            <div class="report white-bgcolor">
                <div class="weui-cells__title rp_head" ><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp;个人多重借贷</span></div>
                @if($report["multipleLoan"]["state"]==0)
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd">{{$report["multipleLoan"]["msg"]}}</div>
                    </div>
                @else
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label>信贷平台注册数：</label></div>
                        <div class="weui-cell__bd">
                            {{ count($report["multipleLoan"]["creditPlatformRegistrationDetails"])}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">贷款申请次数：</label></div>
                        <div class="weui-cell__bd">
                            {{count($report["multipleLoan"]["loanApplicationDetails"])}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">贷款放款次数：</label></div>
                        <div class="weui-cell__bd">
                            {{ count($report["multipleLoan"]["loanDetails"])}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">贷款驳回次数：</label></div>
                        <div class="weui-cell__bd">
                            {{ count($report["multipleLoan"]["loanRejectDetails"])}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">贷款逾期次数：</label></div>
                        <div class="weui-cell__bd">
                            <?php $i=0;?>
                            @if(count($report["multipleLoan"]["overduePlatformDetails"])>0)
                                    @foreach($report["multipleLoan"]["overduePlatformDetails"] as $item)
                                        <?php $i=$i+$item->counts?>
                                    @endforeach
                            @endif
                                {{$i}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">欠款次数：</label></div>
                        <div class="weui-cell__bd">
                            {{ count($report["multipleLoan"]["arrearsInquiry"])}}
                        </div>
                    </div>
                @endif
            </div>
        @endif
        @if(isset($report["personInquiry"]))
            <div class="report white-bgcolor">
                <div class="weui-cells__title rp_head" ><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp;个人涉诉</span></div>
                @if($report["personInquiry"]["state"]==0)
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd">{{$report["personInquiry"]["msg"]}}</div>
                    </div>
                @else
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">开庭公告数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["personInquiry"]["statistic"]->ktggResultSize}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">裁判文书数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["personInquiry"]["statistic"]->cpwsResultSize}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">执行公告数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["personInquiry"]["statistic"]->zxggResultSize}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">失信公告数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["personInquiry"]["statistic"]->sxggResultSize}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">法院公告数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["personInquiry"]["statistic"]->fyggResultSize}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">网贷黑名单数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["personInquiry"]["statistic"]->wdhmdResultSize}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">案件流程：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["personInquiry"]["statistic"]->ajlcResultSize}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">曝光台：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["personInquiry"]["statistic"]->bgtResultSize}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                            <div class="weui-cell__hd"><label class="weui-label">涉诉记录数：</label></div>
                            <div class="weui-cell__bd">
                                {{$report["personInquiry"]["pagination"]->resultSize}}
                            </div>
                            <div class="weui-cell__hd"><label class="weui-label">总页数：</label></div>
                            <div class="weui-cell__bd">
                                {{$report["personInquiry"]["pagination"]->totalPage}}
                            </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div style="float: right;font-size: 10px;color: #0f9ae0;"><a href="javascript:void(0)">查看详情</a></div>
                    </div>
                @endif
            </div>
        @endif
        @if(isset($report["enterpriseInquiry"]))
            <div class="report white-bgcolor">
                <div class="weui-cells__title rp_head" ><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp;企业涉诉</span></div>
                @if($report["personInquiry"]["state"]==0)
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd">{{$report["enterpriseInquiry"]["msg"]}}</div>
                    </div>
                @else
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">开庭公告数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["enterpriseInquiry"]["statistic"]->ktggResultSize}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">裁判文书数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["enterpriseInquiry"]["statistic"]->cpwsResultSize}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">执行公告数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["enterpriseInquiry"]["statistic"]->zxggResultSize}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">失信公告数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["enterpriseInquiry"]["statistic"]->sxggResultSize}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">法院公告数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["enterpriseInquiry"]["statistic"]->fyggResultSize}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">网贷黑名单数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["enterpriseInquiry"]["statistic"]->wdhmdResultSize}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">案件流程：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["enterpriseInquiry"]["statistic"]->ajlcResultSize}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">曝光台：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["enterpriseInquiry"]["statistic"]->bgtResultSize}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd"><label class="weui-label">涉诉记录数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["enterpriseInquiry"]["pagination"]->resultSize}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">总页数：</label></div>
                        <div class="weui-cell__bd">
                            {{$report["enterpriseInquiry"]["pagination"]->totalPage}}
                        </div>
                    </div>
                    <div class="weui-cell" style="color: #666666;" >
                        <div style="float: right;font-size: 10px;color: #0f9ae0;"><a href="javascript:void(0)">查看详情</a></div>
                    </div>
                @endif
            </div>
        @endif
        @if(isset($report["company"]))
        <div class="report white-bgcolor">
            @if($report["company"]["state"]==0)
                <div class="weui-cells__title rp_head"><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp;名下企业</span></div>
                <div class="weui-cell" style="color: #666666;" >
                    <div class="weui-cell__hd">无</div>
                </div>
                <div class="weui-cells__title rp_head"><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp; 股份企业</span></div>
                <div class="weui-cell" style="color: #666666;" >
                    <div class="weui-cell__hd">无</div>
                </div>
                <div class="weui-cells__title rp_head"><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp; 任职情况</span></div>
                <div class="weui-cell" style="color: #666666;" >
                    <div class="weui-cell__hd">无</div>
                </div>
                <div class="weui-cells__title rp_head"><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp;   被执行人信息</span></div>
                <div class="weui-cell" style="color: #666666;" >
                    <div class="weui-cell__hd">无</div>
                </div>
                <div class="weui-cells__title rp_head"><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp;   行政处罚</span></div>
                <div class="weui-cell" style="color: #666666;" >
                    <div class="weui-cell__hd">无</div>
                </div>
            @else
                <div class="weui-cells__title rp_head"><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp;名下企业</span></div>
            @if ($report["company"]["corporates"][0]!=null)
                    <?php $corporate=$report["company"]["corporates"][0]?>
                        <div class="weui-cell" style="color: #666666;" >
                            <div class="weui-cell__hd">企业名:</div>
                            <div class="weui-cell__bd">
                                {{$corporate->entName}}
                            </div>
                        </div>
                        <div class="weui-cell" style="color: #666666;" >
                            <div class="weui-cell__hd">注册号:</div>
                            <div class="weui-cell__bd">
                                {{$corporate->regNo}}
                            </div>
                        </div>
                        <div class="weui-cell" style="color: #666666;" >
                            <div class="weui-cell__hd"><label class="weui-label">注册资本(万元):</label></div>
                            <div class="weui-cell__bd">
                                {{$corporate->regCap}}
                            </div>
                            <div class="weui-cell__hd">币种:</div>
                            <div class="weui-cell__bd">
                                {{$corporate->regCapCur}}
                            </div>
                        </div>
                        <div class="weui-cell" style="color: #666666;" >
                            <div class="weui-cell__hd"><label class="weui-label">经营状态：</label></div>
                            <div class="weui-cell__bd">
                                {{$corporate->entStatus}}
                            </div>
                        </div>
                        <div class="weui-cell" style="color: #666666;" >
                            <div class="weui-cell__hd">信用代码：</div>
                            <div class="weui-cell__bd">
                                {{substr_replace($corporate->creditNo,"****",6,6)}}
                            </div>
                        </div>
                        <div class="weui-cell" style="color: #666666;" >
                            <div class="weui-cell__hd">类型：</div>
                            <div class="weui-cell__bd">
                                {{$corporate->entType}}
                            </div>
                        </div>

                @endif
                       <div class="weui-cells__title rp_head"><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp;股份企业</span></div>
                       @if (count($report["company"]["corporateShareholders"])>0)   @foreach($report["company"]["corporateShareholders"] as $key=>$holder)
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd" style="color: red">企业{{++$key}}：</div>
                               <div class="weui-cell__bd">
                                   {{$holder->entName}}
                               </div>
                           </div>
                           <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd">注册号：</div>
                        <div class="weui-cell__bd">
                            {{$holder->regNo}}
                        </div>
                    </div>
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">注册资本：</div>
                               <div class="weui-cell__bd">
                                   {{$holder->regCap}}
                               </div>
                               <div class="weui-cell__hd">币种：</div>
                               <div class="weui-cell__bd">
                                   {{$holder->regCapCur}}
                               </div>
                           </div>
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">出资额：</div>
                               <div class="weui-cell__bd">
                                   {{$holder->subConam}}
                               </div>
                               <div class="weui-cell__hd">出资比例：</div>
                               <div class="weui-cell__bd">
                                   {{$holder->fundedRatio}}
                               </div>
                           </div>
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">企业状态：</div>
                               <div class="weui-cell__bd">
                                   {{$holder->entStatus}}
                               </div>
                           </div>
                           <div class="weui-cell" style="color: #666666;" >
                        <div class="weui-cell__hd">信用代码：</div>
                        <div class="weui-cell__bd">
                            {{$holder->creditNo}}
                        </div>
                        </div>
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">类型：</div>
                               <div class="weui-cell__bd">
                                   {{$holder->entType}}
                               </div>
                           </div>
                        @endforeach
                   @else   <div class="weui-cell" style="color: #666666;" >
                       <div class="weui-cell__hd">无</div>
                   </div>
                   @endif
                       <div class="weui-cells__title rp_head"><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp; 任职情况</span></div>
                       @if (count($report["company"]["corporateManagers"])>0)  @foreach($report["company"]["corporateManagers"] as $manager)
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">企业名称：</div>
                               <div class="weui-cell__bd">
                                   {{$manager->entName}}
                               </div>
                               <div class="weui-cell__hd">职位：</div>
                               <div class="weui-cell__bd">
                                   {{$manager->position}}
                               </div>
                           </div>
                       @endforeach
                   @else   <div class="weui-cell" style="color: #666666;" >
                       <div class="weui-cell__hd">无</div>
                   </div>
                   @endif
                       <div class="weui-cells__title rp_head"><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp; 被执行人信息</span></div>
                   @if (count($report["company"]["punished"])>0)
                       @foreach($report["company"]["punished"] as $punished)
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">企业名称：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->name}}
                               </div>
                               <div class="weui-cell__hd">性别：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->sex}}
                               </div>
                           </div>
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">法院：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->courtName}}
                               </div>
                               <div class="weui-cell__hd">立案时间：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->regDate}}
                               </div>
                           </div>
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">案件状态：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->caseState}}
                               </div>
                           </div>
                       @endforeach
                       @else   <div class="weui-cell" style="color: #666666;" >
                       <div class="weui-cell__hd">无</div>
                   </div>
                   @endif
                       <div class="weui-cells__title rp_head"><img src="{{asset('wechat/images/icon1.png')}}" alt="" style="vertical-align:middle;"><span style="font-size: 14px;">&nbsp; 行政处罚</span></div>
                   @if (count($report["company"]["caseInfos"])>0)
                       @foreach($report["company"]["caseInfos"] as $case)
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">案由：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->caseReason}}
                               </div>
                               <div class="weui-cell__hd">案发时间：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->caseTime}}
                               </div>
                           </div>
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">执行类别：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->exeSort}}
                               </div>
                               <div class="weui-cell__hd">案件类型：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->caseType}}
                               </div>
                           </div>
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">处罚机构：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->penAuth}}
                               </div>
                               <div class="weui-cell__hd">违法事实：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->illegFact}}
                               </div>
                           </div>
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">处罚依据：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->penBasis}}
                               </div>
                               <div class="weui-cell__hd">处罚种类：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->penType}}
                               </div>
                           </div>
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">处罚结果：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->penResult}}
                               </div>
                               <div class="weui-cell__hd">处罚金额：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->penAm}}
                               </div>
                           </div>
                           <div class="weui-cell" style="color: #666666;" >
                               <div class="weui-cell__hd">处罚执行情况：</div>
                               <div class="weui-cell__bd">
                                   {{$punished->penExeSt}}
                               </div>
                           </div>
                       @endforeach
                   @else   <div class="weui-cell" style="color: #666666;" >
                       <div class="weui-cell__hd">无</div>
                   </div>
                   @endif
        </div>
        @endif @endif
    </div></section>
@include('wechat.layouts.footer')
</body>
</html>