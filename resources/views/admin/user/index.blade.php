@extends('layouts.body')

@section('body')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">用户列表</h3>
                </div>
                <div class="box-header">
                    <a href="{{ url('/admin/user/create') }}"><button class="btn btn-success btn-flat">+ 添加用户</button></a>
                </div>

                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>用户状态</th>
                            <th>操作</th>
                        </tr>

                        @if($user_list)
                            @foreach($user_list as $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->username }}</td>
                                    <td>
                                        @if($value->is_disable == 0)
                                            启用
                                        @else
                                            禁用
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/user/'.$value->id.'/edit')}}">编辑</a> |
                                        <a href="javascript:void(0)" id="{{$value->id}}" is_disable="{{$value->is_disable}}" class="disabled">
                                            @if($value->is_disable == 0)
                                                禁用
                                            @else
                                                启用
                                            @endif
                                        </a> |
                                        <a href="javascript:void(0)" id="{{$value->id}}" class="delete">删除</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
                {!! $user_list->appends(\Illuminate\Support\Facades\Input::get())->render() !!}
            </div>
        </div>
    </div>
    <input type="hidden" name="disable-url" value="{{ url('/admin/user/disable')}}" />
    <input type="hidden" name="delete-url" value="{{ url('/admin/user/delete')}}" />
    <input type="hidden" name="token" value="{{ csrf_token() }}" />
@endsection

@section('js')
    <script>
        $(function(){
            var obj = function () {
                this.dom = {};
            };

            obj.prototype = {
                init:function () {
                    this.initDom();
                    this.bindEvent();
                },
                initDom:function () {
                    this.dom.disable_url = $("input[name='disable-url']").val();
                    this.dom.delete_url = $("input[name='delete-url']").val();
                    this.dom.token = $("input[name='token']").val();
                },
                disabledUser:function (root) {
                    var _dom = this.dom;
                    var _this = $(root);
                    var id =  _this.attr('id');
                    var is_disable = _this.attr('is_disable');
                    var msg = is_disable == 0 ? '禁用' : '启用';
                    layer.msg('你确定要' + msg +'将该用户？', {
                        time: 0 //不自动关闭
                        ,btn: ['　　确定　　', '　　取消　　']
                        ,yes: function(index){
                            $.post(_dom.disable_url, {id:id, is_disable:is_disable, _token:_dom.token }, function(msg){
                                if(msg['code'] == 0){
                                    layer.msg(msg['msg'], {icon: 6});
                                    setTimeout(function(){
                                        window.location.reload();
                                    }, 500);
                                }else{
                                    layer.msg(msg['msg'], {icon: 5});
                                    layer.close(index);
                                }
                            },'json');
                        }
                    });
                },
                deleteUser:function (root) {
                    var _dom = this.dom;
                    var _this = $(root);
                    var id =  _this.attr('id');
                    layer.msg('你确定要删除将该用户？', {
                        time: 0 //不自动关闭
                        ,btn: ['　　确定　　', '　　取消　　']
                        ,yes: function(index){
                            $.post(_dom.delete_url, {id:id, _token:_dom.token}, function(msg){
                                if(msg['code'] == 0){
                                    layer.msg(msg['msg'], {icon: 6});
                                    setTimeout(function(){
                                        window.location.reload();
                                    }, 500);
                                }else{
                                    layer.msg(msg['msg'], {icon: 5});
                                    layer.close(index);
                                }
                            },'json');
                        }
                    });
                },
                bindEvent:function () {
                    var root = this;

                    //禁用，启用用户
                    $(document).on('click', '.disabled', function () {
                        root.disabledUser(this);
                    });

                    //删除用户
                    $(document).on('click', '.delete', function () {
                        root.deleteUser(this);
                    });
                }
            }

            new obj().init();
        })
    </script>
@endsection