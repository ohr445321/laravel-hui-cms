{{--初始化首页页面--}}
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
    <a id="refresh_wrapper" class="btn btn-success radius r" style="line-height: 1.6em;margin-top: 1px;position: absolute;right: 10px;top: 0;z-index: 99999" href="javascript:void(0)" title="刷新">
        <i class="Hui-iconfont"></i>
    </a>
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active"><span title="我的桌面" data-href="welcome.html">我的桌面</span><em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group">
            <a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a>
            <a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a>
        </div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="{{ url('/admin/welcome') }}"></iframe>
        </div>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</section>