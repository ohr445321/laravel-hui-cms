<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CMS登录|盛世创富</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('/static/admin/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/plugins/iCheck/square/blue.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>CMS后台管理</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <form onsubmit="return false;">
                <!--<input type="hidden" name="_token" value="{{ csrf_token() }}" />-->
                <div class="form-group has-feedback">
                    <input type="text" id="user_name" class="form-control" placeholder="账号名/邮箱">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" id="password" class="form-control" placeholder="密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox"> 记住我
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button id="btnLogin" type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <script src="{{ asset('/static/admin/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
    <script src="{{ asset('/static/admin/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/static/admin/js/app.min.js') }}"></script>
    <script src="{{ asset('/static/admin/plugins/layer/layer.js') }}"></script>
    <script type="text/javascript">
        layer.config({
            extend: 'extend/layer.ext.js'
        });

        $(function () {

            $("#btnLogin").click(function () {
                var user_name = $.trim($("#user_name").val());
                var password = $.trim($("#password").val());
                if(user_name==''){
                    $("#user_name").focus();
                    layer.msg("请输入账号名/邮箱", {icon: 5,time: 2000});
                    return false;
                }
                if(password==''){
                    $("#password").focus();
                    layer.msg("请输入密码", {icon: 5,time: 2000});
                    return false;
                }
                $.ajax({
                    url: "/admin/system/check-login",
                    type: 'post',
                    dataType: 'json',
                    data: {'_token':'{{ csrf_token() }}','user_name':user_name,'password':password},
                    async:false,
                    success: function(data){
                        if(data.code==40204){
                            $("#user_name").focus();
                            layer.msg("该帐号不存在！", {icon: 5,time: 2000});
                        }
                        else if(data.code==40207){
                            $("#password").focus();
                            layer.msg("密码不正确！", {icon: 5,time: 2000});
                        }
                        else if(data.code==0){
                            //layer.msg("登录成功", {icon: 1,time: 2000});
                            window.location.href = '/admin';
                        }
                        else{
                            layer.msg(data.msg, {icon: 5,time: 2000});
                        }
                    }
                });
            });
        })
    </script>
</body>