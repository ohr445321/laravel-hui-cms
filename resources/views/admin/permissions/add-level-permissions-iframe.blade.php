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
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>上级权限菜单：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box">
                    <select class="select" size="1" name="parent_id">
                        <option value="0" level="0" parent_path_code="">作为一级菜单</option>
                        @foreach($permissions_tree_data as $vo)
                            @if($vo['id'] == $parent_id)
                                <option value="{{ $vo['id'] }}" level="{{ $vo['level'] }}" parent_path_code="{{ $vo['path_code'] }}" selected>{{ $vo['permissions_name'] }}</option>
                            @else
                                <option value="{{ $vo['id'] }}" level="{{ $vo['level'] }}" parent_path_code="{{ $vo['path_code'] }}" >{{ $vo['permissions_name'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限菜单名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="权限菜单名称" name="permissions_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>路由名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="路由名称" name="route_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">图标：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="图标" name="icon" />
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否显示菜单：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="radio-box">
                    <input type="radio" name="is_meun" value="0" checked>
                    <label for="radio-1">否</label>
                </div>
                <div class="radio-box">
                    <input type="radio" name="is_meun" value="1">
                    <label for="radio-2">是</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否接口：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="radio-box">
                    <input type="radio" name="is_api" value="0" checked>
                    <label for="radio-1">否</label>
                </div>
                <div class="radio-box">
                    <input type="radio" name="is_api" value="1">
                    <label for="radio-2">是</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="排序" name="sort" />
            </div>
        </div>
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
                this.dom.post_url = "{{ url('admin/permissions/') }}";
            },
            vaildate:function(){
                var flag = true;
                var permissions_name = $("input[name='permissions_name']").val();
                var route_name = $("input[name='route_name']").val();

                if (!permissions_name || permissions_name == undefined) {
                    layer.msg('权限菜单名称不能为空~', {icon: 5,time: 2500});
                    return false;
                }
                if (!route_name || route_name == undefined) {
                    layer.msg('路由名称不能为空~', {icon: 5,time: 2500});
                    return false;
                }

                return flag;
            },
            pushData:function(){
                var parent_id = $("select[name='parent_id']").val();
                var level = $("select[name='parent_id']").find('option:selected').attr('level');
                var parent_path_code = $("select[name='parent_id']").find('option:selected').attr('parent_path_code');
                var permissions_name = $("input[name='permissions_name']").val();
                var route_name = $("input[name='route_name']").val();
                var icon = $("input[name='icon']").val();
                var is_meun = $("input[name='is_meun']:checked").val();
                var is_api = $("input[name='is_api']:checked").val();
                var sort = $("input[name='sort']").val();
                var _token = $("input[name='_token']").val();

                var post_data = {
                    _token: _token,
                    parent_id: parent_id,
                    level: level,
                    parent_path_code: parent_path_code,
                    permissions_name: permissions_name,
                    route_name: route_name,
                    icon: icon,
                    is_meun: is_meun,
                    is_api: is_api,
                    sort: sort
                };
                if (this.vaildate()) {
                    $.post(this.dom.post_url, post_data, function(msg){
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