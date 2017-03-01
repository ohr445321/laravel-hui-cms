<!DOCTYPE HTML>
<html>
<head>
    @include('layouts._meta')
    <link rel="stylesheet" type="text/css" href="{{ asset('/static/admin/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css') }}" />
</head>
<body>
<article class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-role-add">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />权限设置
        <div class="tree">
            <ul id="treeDemo" class="ztree"></ul>
        </div>
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
<script type="text/javascript" src="{{ asset('/static/admin/lib/zTree/v3/js/jquery.ztree.core-3.5.js') }}"></script>
<script type="text/javascript" src="{{ asset('/static/admin/lib/zTree/v3/js/jquery.ztree.excheck-3.5.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('/static/admin/lib/jquery.treetable/jquery.treetable.js') }}"></script> -->
<script type="text/javascript">
    $(function(){
        var obj = function(options) {
            this.dom = {};
            this.options = options; //无扩展 以后再慢慢来。。。。
        }

        obj.prototype = {
            init:function(){
                this.initDom();
                this.bindEvent();
            },
            initDom:function(){
                var dom = this.dom;
                var self = this;
                dom.post_url = "{{ url('admin/role/ajax-save-role-permissions') }}";
                dom._token = "{{ csrf_token() }}";
                dom.chkIds = [];
                dom.setting = {
                    check: {
                        enable: true
                    },
                    data: {
                        key:{
                            checked:'is_select',
                            name:"permissions_name"
                        },
                        simpleData: {
                            enable: true,
                            idKey:"id",
                            pIdKey:"parent_id",
                            rootPId:null,
                        },
                    },
                    view: {
                        showIcon:false
                    },
                    callback:{
                        onCheck:function(e,treeId,treeNode){
                            dom.chkIds = [];
                            var zTree = $.fn.zTree.getZTreeObj("treeDemo");
                            checkCount = zTree.getCheckedNodes(true).length;
                            $.each(zTree.getCheckedNodes(true),function(index,item){
                                dom.chkIds.push(item.id);
                            })
                        }
                    }
                };
                $.post("{{ url('admin/role/ajax-get-role-permissions') }}", {'_token': this.dom._token, id: 1}, function (data) {
                    $.fn.zTree.init($("#treeDemo"), dom.setting, data.data);
                }, 'json');
            },
            relateChk:function(root){
                console.log($(root).parents('tr'));
            },
            vaildate:function(){
            },
            pushData:function(){
                var dom = this.dom;
                var role_id = $('input[name="role_id"]').val();
                var data = {
                    role_id:role_id,
                    _token:dom._token,
                    permissions_ids : ''
                }
                data.permissions_ids = dom.chkIds.join(',');

                $.post(dom.post_url, data, function(msg){
                    if (msg.code == 0) {
                        layer.msg(msg.msg, {icon: 1,time: 1500},function(){
                            parent.location.reload();
                        });
                    }else{
                        layer.msg(msg.msg, {icon: 5,time: 1500});
                    }
                }, 'json');
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
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>