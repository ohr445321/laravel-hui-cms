<!DOCTYPE HTML>
<html>
<head>
    @include('layouts._meta')
</head>
<body>
    <div class="page-container">
        <form action="{{ url('/admin/role/') }}" method="get" class="form form-horizontal">
            <div class="text-l">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="text" class="input-text" style="width:350px" placeholder="输入ID、角色名称、角色描述" name="keyword" value="@if(!empty($data['get_data']['keyword'])){{ $data['get_data']['keyword'] }}@endif">
                <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
                <a href="javascript:;" href-url="{{ url('/admin/role/create') }}" class="btn btn-primary radius add-role"><i class="Hui-iconfont">&#xe600;</i> 添加</a>
            </div>
        </form>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                    <tr class="text-c">
                        <th width="25"><input type="checkbox" name="" value=""></th>
                        <th>ID</th>
                        <th>角色名称</th>
                        <th>角色描述</th>
                        <th>角色状态</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data['list_data'])
                        @foreach($data['list_data'] as $value)
                            <tr class="text-c">
                                <td><input type="checkbox" value="1" name=""></td>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->role_name }}</td>
                                <td>{{ $value->remark }}</td>
                                <td>
                                    @if($value->is_disable == 0)
                                        <span class="label label-success radius">已启用</span>
                                    @else
                                        <span class="label label-danger radius">已禁用</span>
                                    @endif
                                </td>
                                <td>{{ $value->create_time }}</td>
                                <td>
                                    <a class='role-permissions' href="javascript:;" href-url="{{ url('/admin/role/role-permissions-iframe/'.$value->id)}}">权限设置</a> |
                                    <a class='role-edit' href="javascript:;" href-url="{{ url('/admin/role/'.$value->id.'/edit')}}">编辑</a> |
                                    <a href="javascript:void(0)" class="role-delete" href-url="{{ url('/admin/role/'.$value->id)}}">删除</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        {!! $data['list_data']->appends(\Illuminate\Support\Facades\Input::get())->links() !!}
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
                    this.dom.token = "{{ csrf_token() }}";
                },
                addRole:function (root) {
                    var _this = $(root);
                    var href_url = _this.attr('href-url');
                    layer.open({
                        title:'添加角色',
                        type: 2,
                        area: ['768px', '430px'],
                        fix: false, //不固定
                        maxmin: true,
                        content: href_url
                    });
                },
                editRole:function (root) {
                    var _this = $(root);
                    var href_url = _this.attr('href-url');
                    layer.open({
                        title:'编辑角色',
                        type: 2,
                        area: ['768px', '430px'],
                        fix: false, //不固定
                        maxmin: true,
                        content: href_url
                    });
                },
                deleteRole:function (root) {
                    var _dom = this.dom;
                    var _this = $(root);
                    var href_url = _this.attr('href-url');
                    layer.msg('你确定要删除将该用户角色？', {
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
                rolePermissions:function (root) {
                    var _this = $(root);
                    var href_url = _this.attr('href-url');
                    layer.open({
                        title:'权限设置',
                        type: 2,
                        area: ['768px', '550px'],
                        fix: false, //不固定
                        maxmin: true,
                        content: href_url
                    });
                },
                bindEvent:function () {
                    var root = this;

                    //添加角色
                    $(document).on('click', '.add-role', function () {
                        root.addRole(this);
                    });

                    //编辑用户角色
                    $(document).on('click', '.role-edit', function () {
                        root.editRole(this);
                    });

                    //删除用户角色
                    $(document).on('click', '.role-delete', function () {
                        root.deleteRole(this);
                    });

                    //权限设置
                    $(document).on('click', '.role-permissions', function() {
                        root.rolePermissions(this);
                    });
                }
            }

            new obj().init();
        })
    </script>
</body>
</html>