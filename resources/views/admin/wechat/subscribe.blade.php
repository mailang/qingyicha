@include('admin.layouts.header')
<body>
<article class="page-container">
    <form class="form form-horizontal" method="post" action="{{route('subscribe.store')}}" id="form-admin-add">
        <input type="hidden"  name="_token" value="{{ csrf_token() }}" />
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> 关注回复：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea id="description" name="description"  cols="" rows="" class="textarea valid" dragonfly="true" >{{ $subscribe }}
                </textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
            </div>
            <div >

            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>
@include('admin.layouts.footer')
<!--/请在上方写此页面业务相关的脚本-->
</body>