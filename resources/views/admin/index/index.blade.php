<!DOCTYPE HTML>
<html>
<head>
    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />

    @include('layouts._meta')

    <title>CMS后台系统</title>
    <meta name="keywords" content="盛世创富">
    <meta name="description" content="盛世创富CMS后台系统。">
</head>
<body>

@include('layouts.header')
@include('layouts.left')
@include('layouts.body')

@include('layouts._footer')

</body>
<script>
    $(function(){
        var obj = function () {
            this.dom = {};
        };

        obj.prototype = {
            init:function () {
                this.bindEvent();
                this.initDom();
            },
            initDom:function () {
                this.dom._token = $("input[name='_token']").val();
            },
            //个人信息
            userInfo:function (root) {
                var _this = $(root);
                var href_url = _this.attr('href-url');
                layer.open({
                    title:'编辑个人信息',
                    type: 2,
                    area: ['768px', '430px'],
                    fix: false, //不固定
                    maxmin: true,
                    content: href_url
                });
            },
            //修改密码
            editPassword:function (root) {
                var _this = $(root);
                var href_url = _this.attr('href-url');
                layer.open({
                    title:'修改密码',
                    type: 2,
                    area: ['768px', '430px'],
                    fix: false, //不固定
                    maxmin: true,
                    content: href_url
                });
            },
            //退出登录
            logout:function (root) {
                var _this = $(root);
                var href_url = _this.attr('href-url');
                var post_data = {
                    _token: this.dom._token,
                }
                $.post(href_url, post_data, function (msg) {
                    if (msg.code == 0) {
                        layer.msg('退出系统成功~', {icon: 6});
                        window.location.href = "{{ url('/admin/login') }}";
                    }
                }, 'json');
            },
            bindEvent:function () {
                var root = this;

                //个人信息
                $(document).on('click', '.user-info', function () {
                    root.userInfo(this);
                });

                //修改密码
                $(document).on('click', '.edit-password', function () {
                    root.editPassword(this);
                });

                //退出登陆
                $(document).on('click', '.logout', function () {
                    root.logout(this);
                });
            }
        };

        new obj().init();
    });
</script>
</html>