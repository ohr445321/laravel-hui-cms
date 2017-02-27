<!DOCTYPE HTML>
<html>
<head>
    @include('layouts._meta')
    <link href="{{ asset('/static/admin/static/h-ui.admin/css/H-ui.login.css') }}" rel="stylesheet" type="text/css" />
    <title>CMS后台登录 1.0</title>
    <meta name="keywords" content="CMS后台管理系统1.0">
    <meta name="description" content="CMS后台管理系统1.0">
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="header"></div>
<div class="loginWraper">
    <div id="loginform" class="loginBox">
        <a href="" class="logo-a">
            <p>CMS管理系统</p>
        </a>
        <form class="form form-horizontal" action="#" method="post">
            <div class="row cl">
                <div class="formControls col-xs-8">
                    <i class="Hui-iconfont">&#xe60d;</i>
                    <input id="" name="username" type="text" placeholder="账户" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8">
                    <i class="Hui-iconfont">&#xe60e;</i>
                    <input id="" name="password" type="password" placeholder="密码" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input name="" type="button" class="btn btn-success radius size-L post-submit" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        </form>
    </div>
</div>


@include('layouts._footer')

</body>
<script>
    $(function(){
        $(document).on('click', '.post-submit', function () {
            var username = $("input[name='username']").val();
            var password = $("input[name='password']").val();
            var _token = $("input[name='_token']").val();
            if (!username || username == undefined) {
                $("input[name='username']").focus();
                layer.msg('请输入用户名~', {icon: 5});
                return false;
            }
            if (!password || username == undefined) {
                $("input[name='password']").focus();
                layer.msg('请输入用户密码~', {icon: 5});
                return false;
            }
            var post_data = {
                _token: _token,
                username: username,
                password: password,
            };
            $.post("{{ url('/admin/check-login') }}", post_data, function (msg) {
                if (msg.code == 0) {
                    layer.msg('登陆成功~', {icon: 6,time: 1500});
                    window.location.href = "{{ url('/admin') }}"
                } else {
                    layer.msg(msg.msg, {icon: 5,time: 1500});
                }

            }, 'json');
        });
    });
</script>
</html>