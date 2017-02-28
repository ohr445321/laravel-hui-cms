<!DOCTYPE HTML>
<html>
<head>
    @include('layouts._meta')
</head>
<body>
<article class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-role-add">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        权限设置
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input type="hidden" name="role_id" value="{{ $id }}"/>
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
                this.dom.post_url = "{{ url('admin/role/') }}";
                this.dom._token = "{{ csrf_token() }}";
                $.post("{{ url('admin/role/ajax-get-role-permissions') }}", {'_token': this.dom._token, id: 1}, function (data) {
                    console.log(data);
                }, 'json');
            },
            vaildate:function(){
                var flag = true;
                var role_name = $("input[name='role_name']").val();

                if (!role_name || role_name == undefined) {
                    layer.msg('角色名称不能为空~', {icon: 5,time: 2500});
                    return false;
                }

                return flag;
            },
            pushData:function(){
                var form_data = {};

                $('#form-role-add').serializeArray().map(function(x){
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