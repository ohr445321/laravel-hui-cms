<!DOCTYPE HTML>
<html>
<head>
    @include('layouts._meta')
</head>
<body>
    <div class="page-container">
        <form action="{{ url('/admin/user/') }}" method="get" class="form form-horizontal">
            <div class="text-l">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="text" class="input-text" style="width:350px" placeholder="输入ID、用户名、邮箱" name="keyword" value="@if(!empty($data['get_data']['keyword'])){{ $data['get_data']['keyword'] }}@endif">
                <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
                <a href="javascript:;" href-url="{{ url('/admin/user/create') }}" class="btn btn-primary radius add-user"><i class="Hui-iconfont">&#xe600;</i> 添加</a>
            </div>
        </form>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                    <tr class="text-c">
                        <th width="25"><input type="checkbox" name="" value=""></th>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>性别</th>
                        <th>邮箱</th>
                        <th>角色</th>
                        <th>用户状态</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data['user_list'])
                        @foreach($data['user_list'] as $value)
                            <tr class="text-c">
                                <td><input type="checkbox" value="1" name=""></td>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->username }}</td>
                                <td>{{ $value->sex }}</td>
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->role_name }}</td>
                                <td>
                                    @if($value->is_disable == 0)
                                        <span class="label label-success radius">已启用</span>
                                    @else
                                        <span class="label label-danger radius">已禁用</span>
                                    @endif
                                </td>
                                <td>{{ $value->create_time }}</td>
                                <td>
                                    <a class='edit-user' href="javascript:;" href-url="{{ url('/admin/user/'.$value->id.'/edit')}}">编辑</a> |
                                    <a class='update-password' href="javascript:;" href-url="{{ url('/admin/user/update-password-iframe/'.$value->id )}}">修改密码</a> |
                                    <a href="javascript:void(0)" id="{{$value->id}}" is_disable="{{$value->is_disable}}" class="user-disabled">
                                        @if($value->is_disable == 0)
                                            禁用
                                        @else
                                            启用
                                        @endif
                                    </a> |
                                    <a href="javascript:void(0)" class="user-delete" href-url="{{ url('/admin/user/'.$value->id)}}">删除</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        {!! $data['user_list']->appends(\Illuminate\Support\Facades\Input::get())->links() !!}
    </div>

    @include('layouts._footer')

    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript">
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
                    this.dom.disable_url = "{{ url('/admin/user/disable')}}";
                    this.dom.delete_url = "{{ url('/admin/user/delete')}}";
                    this.dom.token = "{{ csrf_token() }}";
                },
                addUser:function (root) {
                    var _this = $(root);
                    var href_url = _this.attr('href-url');
                    layer.open({
                        title:'添加用户',
                        type: 2,
                        area: ['768px', '430px'],
                        fix: false, //不固定
                        maxmin: true,
                        content: href_url
                    });
                },
                editUser:function (root) {
                    var _this = $(root);
                    var href_url = _this.attr('href-url');
                    layer.open({
                        title:'编辑用户',
                        type: 2,
                        area: ['768px', '430px'],
                        fix: false, //不固定
                        maxmin: true,
                        content: href_url
                    });
                },
                updatePassword:function (root) {
                    var _this = $(root);
                    var href_url = _this.attr('href-url');
                    layer.open({
                        title:'修改用户密码',
                        type: 2,
                        area: ['768px', '430px'],
                        fix: false, //不固定
                        maxmin: true,
                        content: href_url
                    });
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
                    var href_url = _this.attr('href-url');
                    layer.msg('你确定要删除将该用户？', {
                        time: 0 //不自动关闭
                        ,btn: ['　　确定　　', '　　取消　　']
                        ,yes: function(index){
                            $.post(href_url, {_token:_dom.token, _method: 'DELETE'}, function(msg){
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

                    //添加用户
                    $(document).on('click', '.add-user', function () {
                        root.addUser(this);
                    });

                    //编辑用户
                    $(document).on('click', '.edit-user', function () {
                        root.editUser(this);
                    });

                    //修改用户密码
                    $(document).on('click', '.update-password', function () {
                        root.updatePassword(this);
                    });

                    //禁用，启用用户
                    $(document).on('click', '.user-disabled', function () {
                        root.disabledUser(this);
                    });

                    //删除用户
                    $(document).on('click', '.user-delete', function () {
                        root.deleteUser(this);
                    });
                }
            }

            new obj().init();
        })
    </script>
</body>
</html>