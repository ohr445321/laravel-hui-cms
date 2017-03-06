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
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $data['user_data']->username }}" placeholder="" id="user-name" name="user_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box">
                    <input name="sex" type="radio" id="sex-1" value="男" @if($data['user_data']->sex == '男') checked="checked" @endif>
                    <label for="sex-1">男</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="sex-2" value="女" name="sex" @if($data['user_data']->sex == '女') checked="checked" @endif>
                    <label for="sex-2">女</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="sex-3" value="保密" name="sex" @if($data['user_data']->sex == '保密') checked="checked" @endif>
                    <label for="sex-3">保密</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="@" name="email" id="email" value="{{ $data['user_data']->email }}">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                @foreach($data['role_data'] as $vo_r)
                    <div class="radio-box">
                        <input name="role_id" type="radio" id="role-{{ $vo_r->id }}" value="{{ $vo_r->id }}" @if($vo_r->id == $data['user_data']->role_id) checked @endif >
                        <label for="role-{{ $vo_r->id }}">{{ $vo_r->role_name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        {{ method_field('PUT') }}
        <input type="hidden" name="user_id" value="{{ $data['user_data']->id }}" />;
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius submit-post" type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input class="btn btn-primary radius close-iframe" type="button" value="&nbsp;&nbsp;关闭&nbsp;&nbsp;">
            </div>
        </div>
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
                this.dom.user_id = $("input[name='user_id']").val();
                this.dom.post_url = "{{ url('admin/user/') }}" + '/' + this.dom.user_id;
            },
            vaildate:function(){
                var flag = true;
                var username = $('#user-name').val();
                var sex = $("input[name='sex']:checked").val();
                var email = $('#email').val();
                var role_id = $("input[name='role_id']:checked").val();

                if (username.length <= 0) {
                    layer.msg('用户名不能为空~', {icon: 5,time: 2500});
                    return false;
                }
                if(!email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
                {
                    layer.msg('邮箱格式不正确~', {icon: 5,time: 2500});
                    return false;
                }
                if (!role_id || role_id == undefined) {
                    layer.msg('请选择角色~', {icon: 5,time: 2500});
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