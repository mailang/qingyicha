@include('wechat.layouts.header')
<body class="white-bgcolor">
<section class="qyc_container">
    <div class="page__bd">
        <div class="headTop">
            <a href="javascript:history.go(-1)" class="back"><i class="iconBack"></i></a><span>企业工商数据详情</span><a class="more"><i class="iconDian"></i><i class="iconDian"></i><i class="iconDian"></i></a>
        </div>
        @if(isset($enterprise['businessData'])&&$enterprise['businessData']!=null)
            <?php $basic=$enterprise['businessData']["basic"]?>
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">企业基本信息</span>
                    </div>
                </div>
              @if(count($basic)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                <div class="weui-cell">
                <div>
                    <span style="display: block;color: green; font-size: 15px;">企业：{{$basic->entName}}</span>
                </div>
                </div>
               <div class="weui-cell ">
                <div class="weui-cell__hd"><label class="weui-label">法人：</label></div>
                <div class="weui-cell__bd font12">
                    {{$basic->fName}}
                </div>
                <div class="weui-cell__hd"><label class="weui-label">经营状态：</label></div>
                <div class="weui-cell__bd font12">
                    {{$basic->entStatus}}
                </div>
              </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label class="weui-label">注册资本：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->regCap}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">实收资本：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->recCap==null?"无":$basic->recCap}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label class="weui-label">注册号：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->regNo}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">原注册号：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->oRigegNo==null?"无":$basic->oRigegNo}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label class="weui-label">企业类型：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->entType}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">开业日期：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->esDate}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>经营期限自：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->opFrom}}
                        </div>
                        <div class="weui-cell__hd"><label class="weui-label">经营期限至：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->opTo}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>住址：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->dom}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>登记机关：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->regorg}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>许可经营项目：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->abuItem}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>一般经营项目：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->cbuItem==null?"无":$basic->cbuItem}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>经营(业务)范围：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->opScope}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>经营(业务)范围及方式：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->opScoandForm?"无":$basic->opScoandForm}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>最后年检年度：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->anCheYear}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>变更日期：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->changDate?"无":$basic->changDate}}
                        </div>
                        <div class="weui-cell__hd"><label>注销日期：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->canDate?"无":$basic->canDate}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>吊销日期：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->revDate?"无":$basic->revDate}}
                        </div>
                        <div class="weui-cell__hd"><label>最后年检日期：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->anCheDate?"无":$basic->anCheDate}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>行业门类代码：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->induStryphyCode?"无":$basic->induStryphyCode}}
                        </div>
                        <div class="weui-cell__hd"><label>行业门类名称：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->induStryphyName?"无":$basic->induStryphyName}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>国民经济行业代码：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->induStryCoCode?"无":$basic->induStryCoCode}}
                        </div>
                        <div class="weui-cell__hd"><label>国民经济行业名称：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->induStryCoName?"无":$basic->induStryCoName}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>统一社会信用代码：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->creditNo}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>行业门类代码及名称：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->industryPhyAll?"无":$basic->industryPhyAll}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>注册地址行政区编号：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->regOrgCode}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>企业英文名：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->entNameEng}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>经营业务范围：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->zsOpScope}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>住所所在行政区：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->domDistrict}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>国民经济行业代码及名称：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->industryCoAll}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>员工人数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->empNum}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>联系电话：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->tel}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>所在省份：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->regOrgProvince}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>省节点编号：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->sextNodeNum}}
                        </div>
                    </div>
                    <div class="weui-cell ">
                        <div class="weui-cell__hd"><label>经营场所：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$basic->opLoc}}
                        </div>
                    </div>
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">股东信息</span>
                    </div>
                </div>
                <?php $shareholder=$enterprise['businessData']["shareholder"]?>

                @if(count($shareholder)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div class="weui-cell__hd"><label>股东总数量：</label></div>
                    <div class="weui-cell__bd font12">
                        {{count($shareholder)}}
                    </div></div>
                    @foreach($shareholder as $item)
                    <div class="weui-cell" style="border-top: 1px solid green;">
                        <div class="weui-cell__hd"><label>股东名称：</label></div>
                        <div class="weui-cell__bd font12">
                            {{$item->shaName}}
                        </div>
                    </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>认缴出资额：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->subConAm}}万元
                            </div>
                            <div class="weui-cell__hd"><label>出资方式：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->conForm}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>出资比例：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->fundedRatio}}
                            </div>
                            <div class="weui-cell__hd"><label>出资日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->conDate}}万元
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>国别：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->country}}
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">高管信息</span>
                    </div>
                </div>
                <?php $shareholderPerson=$enterprise['businessData']["shareholderPersons"]?>
                @if(count($shareholderPerson)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>高管总人数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($shareholderPerson)}}
                        </div></div>
                    @foreach($shareholderPerson as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>姓名：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->name}}
                            </div>
                            <div class="weui-cell__hd"><label>性别：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->sex}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>职位：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->position}}万元
                            </div>

                        </div>
                    @endforeach
                @endif

                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">法人对外投资信息</span>
                    </div>
                </div>
                <?php $legalPersonInvests=$enterprise['businessData']["legalPersonInvests"]?>
                @if(count($legalPersonInvests)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>企业总数量：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($legalPersonInvests)}}
                        </div></div>
                    @foreach($legalPersonInvests as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>法人：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->name}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>机构名称：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->entName}}
                            </div>
                            <div class="weui-cell__hd"><label>机构类型：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->entType}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regNo}}万元
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册资本：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regCap}}万元
                            </div>
                            <div class="weui-cell__hd"><label>经营状态：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->entStatus}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注销日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->canDate}}
                            </div>
                            <div class="weui-cell__hd"><label>吊销日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->revDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>登记机关：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regOrg}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>认缴出资额：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->subConAm}}万元
                            </div>
                            <div class="weui-cell__hd"><label>认缴出资币种：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->curRenCy}}
                            </div>

                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>出资方式：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->conForm}}
                            </div>
                            <div class="weui-cell__hd"><label>出资比例：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->fundedRatio}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>开业日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->esDate}}
                            </div></div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册地址行政区编号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->postCode}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">法人其他任职信息</span>
                    </div>
                </div>
                <?php $legalPersonPostions=$enterprise['businessData']["legalPersonPostions"]?>
                @if(count($legalPersonPostions)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>企业总数量：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($legalPersonPostions)}}
                        </div></div>
                    @foreach($legalPersonPostions as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>法人：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->name}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>机构名称：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->entName}}
                            </div>
                            <div class="weui-cell__hd"><label>机构类型：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->entType}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regNo}}万元
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册资本：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regCap}}万元
                            </div>
                            <div class="weui-cell__hd"><label>经营状态：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->entStatus}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注销日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->canDate}}
                            </div>
                            <div class="weui-cell__hd"><label>吊销日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->revDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>登记机关：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regOrg}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>职务：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->position}}
                            </div>
                            <div class="weui-cell__hd"><label>是否法定代表人：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->lerepSign}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>开业日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->esDate}}
                            </div></div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册地址行政区编号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->postCode}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">企业对外投资信息</span>
                    </div>
                </div>
                <?php $enterpriseInvests=$enterprise['businessData']["enterpriseInvests"]?>
                @if(count($enterpriseInvests)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>企业总数量：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($enterpriseInvests)}}
                        </div></div>
                    @foreach($enterpriseInvests as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>法人：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->name}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>机构名称：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->entName}}
                            </div>
                            <div class="weui-cell__hd"><label>机构类型：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->entType}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regNo}}万元
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册资本：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regCap}}万元
                            </div>
                            <div class="weui-cell__hd"><label>经营状态：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->entStatus}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注销日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->canDate}}
                            </div>
                            <div class="weui-cell__hd"><label>吊销日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->revDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>登记机关：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regOrg}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>认缴出资额：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->subConAm}}万
                            </div>
                            <div class="weui-cell__hd"><label>币种：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->conGroCur}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>出资方式：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->conFrom}}
                            </div>
                            <div class="weui-cell__hd"><label>出资比例：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->fundedRation}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>开业日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->esDate}}
                            </div></div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>统一社会信用代码：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->creditCode}}
                            </div></div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册地址行政区编号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->postCode}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">变更信息</span>
                    </div>
                </div>
                <?php $alterInfos=$enterprise['businessData']["alterInfos"]?>
                @if(count($alterInfos)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>变更总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($alterInfos)}}
                        </div></div>
                    @foreach($alterInfos as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>变更事项：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->altItem}}
                            </div>
                            <div class="weui-cell__hd"><label>变更前内容：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->altBe}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>变更后内容：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->altAf}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>变更日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->altDate}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">分支机构信息</span>
                    </div>
                </div>
                <?php $filiations=$enterprise['businessData']["filiations"]?>
                @if(count($filiations)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($filiations)}}
                        </div></div>
                    @foreach($filiations as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>分支机构名称：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->brName}}
                            </div>
                            <div class="weui-cell__hd"><label>分支机构企业注册号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->brRegNo}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>分支机构负责人：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->brPrincipal}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>一般经营项目：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->cbuItme}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>分支机构地址：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->brAddr}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>统一社会信用代码：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->brnCreditCode}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>分支机构登记机关：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->brnRegOrg}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>主体身份代码：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->brpripId}}
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">失信被执行人信息</span>
                    </div>
                </div>
                <?php $punishBreaks=$enterprise['businessData']["punishBreaks"]?>
                @if(count($punishBreaks)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($punishBreaks)}}
                        </div></div>
                    @foreach($punishBreaks as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>案号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->caseCode}}
                            </div>
                            <div class="weui-cell__hd"><label>案件状态：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->caseState}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>被执行人姓名：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->name}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>失信人类型：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->type}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>性别：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->sex}}
                            </div>
                            <div class="weui-cell__hd"><label>年龄：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->age}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>身份证号码：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->cardNum}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>身份证原始发证地：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->ysfzd}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>法定代表人：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->businessEntity}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>立案时间：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regDate}}
                            </div>
                            <div class="weui-cell__hd"><label>公布时间：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->publishDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>执行法院：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->courName}}
                            </div>
                            <div class="weui-cell__hd"><label>省份：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->areaName}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>执行依据文号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->gistId}}
                            </div>
                            <div class="weui-cell__hd"><label>执行依据单位：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->gistUnit}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>法律义务：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->duty}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>失信行为：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->disruptTypeName}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>履行情况：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->performAnce}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>已履行：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->performedPart}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>未履行：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->unPerformPart}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>退出日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->exitDate}}
                            </div>
                            <div class="weui-cell__hd"><label>关注次数：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->focusNumber}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">被执行人信息</span>
                    </div>
                </div>
                <?php $punished=$enterprise['businessData']["punished"]?>
                @if(count($punished)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($punished)}}
                        </div></div>
                    @foreach($punished as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>案号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->caseCode}}
                            </div>
                            <div class="weui-cell__hd"><label>案件状态：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->caseState}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>被执行人姓名：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->name}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>性别：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->sex}}
                            </div>
                            <div class="weui-cell__hd"><label>年龄：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->age}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>身份证号码：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->cardNum}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>身份证原始发证地：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->ysfzd}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>执行法院：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->courtName}}
                            </div>
                            <div class="weui-cell__hd"><label>省份：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->areaName}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>立案时间：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regDate}}
                            </div>
                            <div class="weui-cell__hd"><label>执行标的：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->execMoney}}万
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>关注次数：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->focusNum}}
                            </div>
                            <div class="weui-cell__hd"><label>失信人类型：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->type}}万
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">股权冻结历史信息</span>
                    </div>
                </div>
                <?php $sharesFrosts=$enterprise['businessData']["sharesFrosts"]?>
                @if(count($sharesFrosts)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($sharesFrosts)}}
                        </div></div>
                    @foreach($sharesFrosts as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>冻结文号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->froDocNo}}
                            </div>
                            <div class="weui-cell__hd"><label>冻结机关：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->froAuth}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>冻结起始日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->froFrom}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>冻结截至日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->froTo}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>冻结金额：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->froAm}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>解冻机关：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->thawAuth}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>解冻文号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->thawDocNo}}
                            </div>
                            <div class="weui-cell__hd"><label>解冻日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->thawDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>解冻说明：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->thawComment}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">清算信息</span>
                    </div>
                </div>
                <?php $liquidations=$enterprise['businessData']["liquidations"]?>
                @if(count($liquidations)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($liquidations)}}
                        </div></div>
                    @foreach($liquidations as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>清算责任人：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->ligEntity}}
                            </div>
                            <div class="weui-cell__hd"><label>清算负责人：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->ligPrincipal}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>清算组成员：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->liQMen}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>清算完结情况：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->liGSt}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>清算完结日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->ligEndDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>债务承接人：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->debtTranee}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>债权承接人：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->claimTranee}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>电话：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->mobile}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>地址：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->address}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">行政处罚历史信息</span>
                    </div>
                </div>
                <?php $caseInfos=$enterprise['businessData']["caseInfos"]?>
                @if(count($caseInfos)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($caseInfos)}}
                        </div></div>
                    @foreach($caseInfos as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>处罚决定文书：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->penDecNo}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>处罚决定书签发日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->penDecIssDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>处罚机关：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->penAuth}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>处罚机关名：</label></div>
                            <div class="weui-cell__bd font12">
                                {{isset($item->penAuthCn)? $item->penAuthCn:""}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>主要违法事实：</label></div>
                            <div class="weui-cell__bd font12">
                             {{isset($item->illegFact)? $item->illegFact:""}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>处罚种类：</label></div>
                            <div class="weui-cell__bd font12">
                          {{isset($item->penType)? $item->penType:""}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>处罚种类中文：</label></div>
                            <div class="weui-cell__bd font12">
                             {{isset($item->penTypeDescription)? $item->penTypeDescription:""}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>处罚内容：</label></div>
                            <div class="weui-cell__bd font12">
                         {{isset($item->penContent)? $item->penContent:""}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>公示日期：</label></div>
                            <div class="weui-cell__bd font12">
                               {{isset($item->announcementDate)? $item->announcementDate:""}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">动产抵押物信息</span>
                    </div>
                </div>
                <?php $morguaInfos=$enterprise['businessData']["morguaInfos"]?>
                @if(count($morguaInfos)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($morguaInfos)}}
                        </div></div>
                    @foreach($morguaInfos as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>综合信息：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->comprehensiveDetail}}
                            </div>
                            <div class="weui-cell__hd"><label>抵押物名称：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->guaName}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>备注：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->remark}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>登记编号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regNo}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>所有权或使用权归属：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->owner}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">动产抵押-变更信息  </span>
                    </div>
                </div>
                <?php $mortgageAlter=$enterprise['businessData']["mortgageAlter"]?>
                @if(count($mortgageAlter)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($mortgageAlter)}}
                        </div></div>
                    @foreach($mortgageAlter as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>变更内容：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->alterDetail}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>变更日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->alterDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>登记编号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->RegNo}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">动产抵押-注销信息 </span>
                    </div>
                </div>
                <?php $mortgageCancels=$enterprise['businessData']["mortgageCancels"]?>
                @if(count($mortgageCancels)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($mortgageCancels)}}
                        </div></div>
                    @foreach($mortgageCancels as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>注销原因：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->cancelReason}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注销日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->cancelDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>登记编号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regNo}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">动产抵押-被担保主债权信息</span>
                    </div>
                </div>
                <?php $mortgageDebtors=$enterprise['businessData']["mortgageDebtors"]?>
                @if(count($mortgageDebtors)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($mortgageDebtors)}}
                        </div></div>
                    @foreach($mortgageDebtors as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>履行债务开始日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->startDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>履行债务结束日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->endtDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>数额：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->amount}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>担保范围：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->range}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>备注：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->remark}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>种类：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->type}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>编号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regNo}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">动产抵押-抵押人信息</span>
                    </div>
                </div>
                <?php $mortgagePersons=$enterprise['businessData']["mortgagePersons"]?>
                @if(count($mortgagePersons)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($mortgagePersons)}}
                        </div></div>
                    @foreach($mortgagePersons as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>抵押权人证件号码：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->credentialNo}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>证件类型：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->credentialType}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>所在地：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->domain}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>抵押权人名称：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->name}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>登记编号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regNo}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">动产抵押-登记信息</span>
                    </div>
                </div>
                <?php $mortgageRegisters=$enterprise['businessData']["mortgageRegisters"]?>
                @if(count($mortgageRegisters)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($mortgageRegisters)}}
                        </div></div>
                    @foreach($mortgageRegisters as $item)
                        <div class="weui-cell " style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>履行债务开始日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->startDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>履行债务结束日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->endDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>被担保债权数额：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->amount}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>担保范围：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->range}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>被担保债券种类：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->type}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>登记编号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regNo}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>登记日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->registerDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>登记机关：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->registerOrg}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>省份代码：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->provinceNo}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>状态：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->status}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">严重违法信息</span>
                    </div>
                </div>
                <?php $breakLaw=$enterprise['businessData']["breakLaw"]?>
                @if(count($breakLaw)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($breakLaw)}}
                        </div></div>
                    @foreach($breakLaw as $item)
                        <div class="weui-cell " style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>列入日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->inDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>列入原因：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->inReason}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>列入作出决定机关：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->inRegOrg}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>列入作出决定文号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->inSn}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>移出日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->outDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>移出原因：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->outReason}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>移出作出决定机关：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->outRegOrg}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>移出作出决定文号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->outSn}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">企业异常名录</span>
                    </div>
                </div>
                <?php $bexceptionLists=$enterprise['businessData']["exceptionLists"]?>
                @if(count($bexceptionLists)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($bexceptionLists)}}
                        </div></div>
                    @foreach($bexceptionLists as $item)
                        <div class="weui-cell " style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>企业名称：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->name}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>企业类型：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->type}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>列入日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->inDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>列入原因：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->inReason}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>移出日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->outDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>移出原因：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->outReason}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regNo}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>统一社会信用代码：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->shxydm}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>列入机关名称：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->inOrg}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>移出机关名称：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->outOrg}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">组织机构代码</span>
                    </div>
                </div>
                <?php $orgBasics=$enterprise['businessData']["orgBasics"]?>
                @if(count($orgBasics)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($orgBasics)}}
                        </div></div>
                    @foreach($orgBasics as $item)
                        <div class="weui-cell " style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>组织机构代码：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->jgdm}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>机构地址：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->jgdz}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>组织机构名称：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->jgmc}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>质疑标志：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->zybz}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">股权出质信息详情</span>
                    </div>
                </div>
                <?php $orgDetails=$enterprise['businessData']["orgDetails"]?>
                @if(count($orgDetails)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>办证机构：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$orgDetails->bzjg}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>代码证办证日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$orgDetails->bzrq}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>法人代表姓名：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$orgDetails->fddbr}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>组织机构代码：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$orgDetails->jgdm}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>机构地址：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$orgDetails->jgdz}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>机构类型：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$orgDetails->jglx}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>组织机构名称：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$orgDetails->jgmc}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>行政区划：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$orgDetails->xzqh}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$orgDetails->zcrq}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>代码证作废日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$orgDetails->zfrq}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>质疑标志：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$orgDetails->zybz}}
                            </div>
                        </div>
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">股权出质信息</span>
                    </div>
                </div>
                <?php $equityInfos=$enterprise['businessData']["equityInfos"]?>
                @if(count($equityInfos)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($equityInfos)}}
                        </div></div>
                    @foreach($equityInfos as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>出质股权数额：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnCzamt}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>出质人证件/证件号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnCzcerno}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>出质人：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnCzper}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>公示日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>质权出质设立登记日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnRegdate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>登记编号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnRegno}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>状态：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnStatus}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>质权人证件/证件号：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnZqcerno}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>质权人姓名：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnZqper}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>关联内容：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->content}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">股权出质信息-变更信息</span>
                    </div>
                </div>
                <?php $equityChangeInfos=$enterprise['businessData']["equityChangeInfos"]?>
                @if(count($equityChangeInfos)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($equityChangeInfos)}}
                        </div></div>
                    @foreach($equityChangeInfos as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>变更内容：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnBgnr}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>变更日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnBgrq}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>关联内容：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->content}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">股权出质信息-注销信息</span>
                    </div>
                </div>
                <?php $cancellationOfInfos=$enterprise['businessData']["cancellationOfInfos"]?>
                @if(count($cancellationOfInfos)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($cancellationOfInfos)}}
                        </div></div>
                    @foreach($cancellationOfInfos as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>注销原因：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnRes}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注销日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->stkPawnDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>关联内容：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->content}}
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                    <div>
                        <span style="display: block;color: green; font-weight: bold; font-size: 15px;">注册商标</span>
                    </div>
                </div>
                <?php $tradeMarks=$enterprise['businessData']["tradeMarks"]?>
                @if(count($tradeMarks)==0)
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div>
                            <span style="display: block;color:darkolivegreen; font-size: 15px;">无</span>
                        </div>
                    </div>
                @else
                    <div class="weui-cell" style="border-bottom: 1px solid #eee;">
                        <div class="weui-cell__hd"><label>总数：</label></div>
                        <div class="weui-cell__bd font12">
                            {{count($tradeMarks)}}
                        </div></div>
                    @foreach($tradeMarks as $item)
                        <div class="weui-cell" style="border-top: 1px solid green;">
                            <div class="weui-cell__hd"><label>申请日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->appDate}}
                            </div>
                            <div class="weui-cell__hd"><label>起始日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->beginDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>初审公告期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->checkDate}}
                            </div>
                            <div class="weui-cell__hd"><label>到期日期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->endDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册码解密：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->markCodeKey}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>商标名称：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->markName}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>商标类型：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->markTypeNew}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>注册公告期：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->regDate}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>商标/服务：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->typeDetailDes}}
                            </div>
                        </div>
                        <div class="weui-cell ">
                            <div class="weui-cell__hd"><label>流程：</label></div>
                            <div class="weui-cell__bd font12">
                                {{$item->markImage}}
                            </div>
                        </div>
                    @endforeach
                @endif
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