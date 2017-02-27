<!DOCTYPE HTML>
<html>
<head>
    @include('layouts._meta')
</head>
<body>
<article class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-user-add">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>原始密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" autocomplete="off" value="" placeholder="原始密码" id="old-password" name="old-password">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>新密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" autocomplete="off"  placeholder="新密码" id="password" name="password">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认新密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" autocomplete="off"  placeholder="确认新密码" id="re-password" name="re-password">
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius submit-post" type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input class="btn btn-primary radius close-iframe" type="button" value="&nbsp;&nbsp;关闭&nbsp;&nbsp;">
            </div>
        </div>
        <input type="hidden" name="user_id" value="{{ $id }}" />;
    </form>
</article>

@include('layouts._footer')

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
    $(function(){
        var obj = function() {
            this.dom = {};
        }

        obj.prototype = {
            init:function(){
                this.initDom();
                this.bindEvent();
            },
            initDom:function(){
                this.dom.post_url = "{{ url('admin/user/update-password') }}";
            },
            vaildate:function(){
                var flag = true;
                var oldpassword = $('#old-password').val();
                var password = $('#password').val();
                var repassword = $('#re-password').val();

                if (oldpassword.length <= 0) {
                    layer.msg('原始密码不能为空~', {icon: 5,time: 2500});
                    return false;
                }
                if (password.length <= 0) {
                    layer.msg('新密码不能为空~', {icon: 5,time: 2500});
                    return false;
                }
                if (repassword.length <= 0) {
                    layer.msg('确认新密码不能为空~', {icon: 5,time: 2500});
                    return false;
                }
                if (repassword !== password) {
                    layer.msg('新密码不一致~', {icon: 5,time: 2500});
                    return false;
                }

                return flag;
            },
            pushData:function(){
                var form_data = {};

                $('#form-user-add').serializeArray().map(function(x){
                    form_data[x.name] = x.value;
                });

                if (this.vaildate()) {
                    $.post(this.dom.post_url, form_data, function(msg){
                        if (msg.code == 0) {
                            layer.msg(msg.msg, {icon: 1,time: 1500},function(){
                                parent.location.reload();
                            });
                        }else{
                            layer.msg(msg.msg, {icon: 5,time: 1500});
                        }
                    }, 'json');
                }
            },
            bindEvent:function(){
                var root = this;

                $(document).on('click', '.submit-post', function(){
                    root.pushData();
                });
            }
        }

        new obj().init();
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>