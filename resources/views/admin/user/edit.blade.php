@extends('layouts.body')

@section('body')
    <div class="row user-wrapper">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑用户</h3>
                </div>

                <form method="post" id="form" class="form-horizontal layui-form" action="{{ url('admin/user/') }}" location_href="{{ url('admin/user/') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="box-body">

                        <div class="form-group require-panel">
                            <label class="col-sm-2 control-label">用户名</label>
                            <div class="col-sm-4">
                                <input type="text" name="user_name" id="user-name" class="form-control" value="{{ $user->username }}" placeholder="用户名" required>
                            </div>
                            <span class="req-el">*必填</span>
                        </div>

                        <div class="form-group require-panel">
                            <label class="col-sm-2 control-label">原始密码</label>
                            <div class="col-sm-4">
                                <input type="password" name="old-password" id="user-old-psw" class="form-control" placeholder="密码(输入六位以上)" required>
                            </div>
                            <span class="req-el">*必填</span>
                        </div>

                        <div class="form-group require-panel">
                            <label class="col-sm-2 control-label">新密码</label>
                            <div class="col-sm-4">
                                <input type="password" name="password" id="user-psw" class="form-control" placeholder="密码(输入六位以上)" required>
                            </div>
                            <span class="req-el">*必填</span>
                        </div>

                        <div class="form-group require-panel">
                            <label class="col-sm-2 control-label">确认新密码</label>
                            <div class="col-sm-4">
                                <input type="password" name="re-password" id="re-user-psw" class="form-control" placeholder="密码(输入六位以上)" required>
                            </div>
                            <span class="req-el">*必填</span>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button type="button" id="submit2" class="btn btn-primary btn-flat submit-post" >确定添加</button>
                                <a href="#" onclick="javascript:history.back(-1);return false;"><button type="button" class="btn btn-success btn-flat">返 回</button></a>
                            </div>
                        </div>
                    </div>
                    {{ method_field('PUT') }}
                </form>
                <input type="hidden" name="user_id" value="{{ $user->id }}" />;
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            var obj = function() {
                this.dom = {};
            }

            obj.prototype = {
                init:function(){
                    this.initDom();
                    this.bindEvent();
                },
                initDom:function(){
                    this.dom.id = $("input[name='user_id']").val();
                    this.dom.post_url = $('#form').attr('action');
                    this.dom.location_href = $('#form').attr('location_href');
                },
                vaildate:function(){
                    var flag = true;
                    var username = $('#user-name').val();
                    var old_password = $('#user-old-psw').val();
                    var password = $('#user-psw').val();
                    var repassword = $('#re-user-psw').val();

                    if (username.length <= 0) {
                        layer.msg('用户名不能为空~', {icon: 5,time: 2500});
                        return false;
                    }
                    if (old_password.length <= 0) {
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
                    var root = this.dom;
                    var form_data = {};

                    $('#form').serializeArray().map(function(x){
                        form_data[x.name] = x.value;
                    });

                    if (this.vaildate()) {
                        $.post(this.dom.post_url + '/' + this.dom.id, form_data, function(msg){
                            if (msg.code == 0) {
                                layer.msg(msg.msg, {icon: 1,time: 1500},function(){
                                    window.location.href = root.location_href;
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
        })
    </script>
@endsection