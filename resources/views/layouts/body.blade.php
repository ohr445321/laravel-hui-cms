<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理|盛世创富</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('/static/admin/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/css/skins/skin-green.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/css/skins/skin-green-light.min.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('/static/admin/css/skins/_all-skins.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('/static/admin/css/jquery.tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/plugins/iCheck/flat/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/plugins/uploadify/uploadify.css') }}">
    @yield('css')
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
@include('layouts.header')
@include('layouts.left')
    <div class="content-wrapper">
        <section class="content">
            @yield('body')
        </section>
    </div>
@include('layouts.footer')
    <script src="{{ asset('/static/admin/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
    <script src="{{ asset('/static/admin/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/static/admin/js/app.min.js') }}"></script>
    <script src="{{ asset('/static/admin/plugins/uploadify/jquery.uploadify.min.js') }}"></script>
    <script src="{{ asset('/static/admin/plugins/layer/layer.js') }}"></script>
    <script src="{{ asset('/static/admin/plugins/laydate/laydate.js') }}"></script>
    <script type="text/javascript">
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        laydate.skin('molv');

        function jsonAjax(url,type,param,dataType,callback){
            $.ajax({
                url: url,
                type: type,
                dataType: dataType,
                data: param,
                async:false,
                success: callback,
            });
        }

    </script>
    @yield('js')
</div>
</body>