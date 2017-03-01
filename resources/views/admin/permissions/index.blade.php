<!DOCTYPE HTML>
<html>
<head>
    @include('layouts._meta')
    <link rel="stylesheet" type="text/css" href="{{ asset('/static/admin/lib/jquery.treetable/jquery.treetable.css') }}">
</head>
<body>
    <div class="page-container menu_power">
        <form action="{{ url('/admin/permissions/') }}" method="get" class="form form-horizontal">
            <div class="text-l">
                {{--<input type="text" class="input-text" style="width:350px" placeholder="ID、路由名称、权限名称" name="keyword" value="@if(!empty($data['get_data']['keyword'])) $data['get_data']['keyword'] @endif">--}}
                {{--<button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>--}}
                <a href="javascript:;" href-url="{{ url('/admin/permissions/create') }}" class="btn btn-primary radius add-user"><i class="Hui-iconfont">&#xe600;</i> 添加权限菜单</a>
            </div>
        </form>
        <div class="mt-20">
            <form class="js-ajax-form" action="{{ url('/admin/permissions/update-permissions-sort') }}" method="get" method="post">
                <div class="table-actions">
                    <button class="btn btn-primary btn-small sort" type="submit">排序</button>
                </div>
                <table id="tableTree" class="table table-border table-bordered table-hover table-bg table-sort">
                    <thead>
                        <tr class="text-c">
                            <th>排序</th>
                            <th>ID</th>
                            <th>菜单名称</th>
                            <th>路由名称</th>
                            <th>上级菜单</th>
                            <th>是否显示</th>
                            <th>是否接口</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($data['list_data'])
                            @foreach($data['list_data'] as $value)
                                <tr class="text-c" data-tt-id="{{ $value['id'] }}" data-tt-parent-id="{{ $value['parent_id'] }}">
                                    <td><input class="sort" type="text" name="{{ $value['id'] }}" value="{{ $value['sort'] }}"></td>
                                    <td>{{ $value['id'] }}</td>
                                    <td>{{ $value['permissions_name'] }}</td>
                                    <td>{{ $value['route_name'] }}</td>
                                    <td>{{ $value['parent_permissions_name'] }}</td>
                                    <td>
                                        @if($value['is_menu'] == 1)
                                            是
                                        @else
                                            否
                                        @endif
                                    </td>
                                    <td>
                                        @if($value['is_api'] == 1)
                                            是
                                        @else
                                            否
                                        @endif
                                    </td>
                                    <td>{{ $value['create_time'] }}</td>
                                    <td>
                                        <a class='add-level-permissions' href="javascript:;" href-url="{{ url('/admin/permissions/add-level-permissions-iframe/'. $value['id'])}}">添加下级菜单</a> |
                                        <a class='edit-permissions' href="javascript:;" href-url="{{ url('/admin/permissions/'.$value['id'].'/edit')}}">编辑</a> |
                                        <a class="destroy-permissions" href="javascript:void(0)" href-url="{{ url('/admin/permissions/'.$value['id']) }}">删除</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="table-actions">
                    <button class="btn btn-primary btn-small sort" type="submit">排序</button>
                </div>
            </form>
        </div>
    </div>

    @include('layouts._footer')
    <!-- <script type="text/javascript" src="{{ asset('/static/admin/lib/zTree/v3/js/jquery.ztree.core-3.5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/static/admin/lib/zTree/v3/js/jquery.ztree.excheck-3.5.js') }}"></script> -->

    <script type="text/javascript" src="{{ asset('/static/admin/lib/jquery.treetable/jquery.treetable.js') }}"></script>
    
    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript">
        $(function(){
            var obj = function (options) {
                this.dom = {};
                // this.options = options;
            };

            obj.prototype = {
                init:function () {
                    this.initDom();
                    this.initTable();
                    this.bindEvent();
                },
                initDom:function () {
                    var dom = this.dom;
                    dom._token = "{{ csrf_token() }}";
                },
                initTable:function(){
                    $('#tableTree').treetable({
                        expandable:true,
                        indent:20,
                        expanderTemplate:'<a href="#" class="Hui-iconfont Hui-iconfont-sanjiao"></a>'
                    });
                },
                addPermissions:function (root) {
                    var _this = $(root);
                    var href_url = _this.attr('href-url');
                    layer.open({
                        title:'添加权限菜单',
                        type: 2,
                        area: ['768px', '450px'],
                        fix: false, //不固定
                        maxmin: true,
                        content: href_url
                    });
                },
                addLevelPermissions:function (root) {
                    var _this = $(root);
                    var href_url = _this.attr('href-url');
                    layer.open({
                        title:'添加下级权限菜单',
                        type: 2,
                        area: ['768px', '450px'],
                        fix: false, //不固定
                        maxmin: true,
                        content: href_url
                    });
                },
                editPermissions:function (root) {
                    var _this = $(root);
                    var href_url = _this.attr('href-url');
                    layer.open({
                        title:'编辑权限菜单',
                        type: 2,
                        area: ['768px', '450px'],
                        fix: false, //不固定
                        maxmin: true,
                        content: href_url
                    });
                },
                destroyPermissions:function (root) {
                    var dom = this.dom;
                    var _this = $(root);
                    var href_url = _this.attr('href-url');
                    layer.msg('你确定要删除将该权限菜单？', {
                        time: 0 //不自动关闭
                        ,btn: ['　　确定　　', '　　取消　　']
                        ,yes: function(index){
                            $.post(href_url, {_token:dom._token, _method: 'DELETE'}, function(msg){
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
                reSort:function(){
                    var dom = this.dom;
                    dom._token = "{{ csrf_token() }}";
                    var data = [];
                    var form = $('.js-ajax-form');
                    var post_url = form.attr('action');
                    var sort = form.find('input');
                    $.each(sort,function(index,item){
                        data.push({
                            id:$(item).attr('name'),
                            sort:$(item).val()
                        })
                    })
                    console.log(data)
                    $.post(post_url, {'_token': dom._token,data:data}, function (msg) {
                        console.log(msg);
                        if(msg['code'] == 0){
                            layer.msg(msg['msg'], {icon: 6});
                            setTimeout(function(){
                                window.location.reload();
                            }, 500);
                        }else{
                            layer.msg(msg['msg'], {icon: 5});
                            layer.close(index);
                        }
                    }, 'json');
                },
                bindEvent:function () {
                    var root = this;

                    //添加权限菜单
                    $(document).on('click', '.add-user', function () {
                        root.addPermissions(this);
                    });

                    //添加下级权限菜单
                    $(document).on('click', '.add-level-permissions', function () {
                        root.addLevelPermissions(this);
                    });

                    //编辑权限菜单
                    $(document).on('click', '.edit-permissions', function () {
                        root.editPermissions(this);
                    });

                    //删除权限菜单
                    $(document).on('click', '.destroy-permissions', function () {
                        root.destroyPermissions(this);
                    });

                    //排序
                    $(document).on('click','.sort',function(){
                        root.reSort();
                        return false;
                    })
                }
            }
            new obj().init();
        })
    </script>
</body>
</html>