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
                        }
                    },
                    view: {
                        showIcon:false
                    },
                    callback:{
                        beforeCheck:function(treeId,treeNode){
                            console.log(treeId)
                        },
                        onCheck:function(e,treeId,treeNode){
                            console.log(treeNode)
                        }
                    }
                };
                $.post("{{ url('admin/role/ajax-get-role-permissions') }}", {'_token': this.dom._token, id: 1}, function (data) {
                    $.fn.zTree.init($("#treeDemo"), dom.setting, data.data);
                    // var str = '<table id="tableTree">';
                    // $.each(dom.data,function(index,item){
                    //     var chk = '';
                    //     if(item.is_select==1){
                    //         chk='checked'
                    //     }
                    //     str += '<tr data-tt-id="'+item.id+'" data-tt-parent-id="'+item.parent_id+'"><td><input type="checkbox" name="role['+item.id+']" value="'+item.id+'" chk/>'+item.permissions_name+'</td></tr>'
                    // })
                    // str += "</table>";
                    // // dom.data.each(function(index,item){
                    // //     console.log(item);
                    // // })
                    // $('.tree').html(str);
                    // $('#tableTree').treetable({
                    //     expandable:true,
                    //     indent:20,
                    //     expanderTemplate:'<a href="#" class="Hui-iconfont Hui-iconfont-sanjiao"></a>'
                    // });

                }, 'json');
            },
            vaildate:function(){
                // var flag = true;
                // var role_name = $("input[name='role_name']").val();

                // if (!role_name || role_name == undefined) {
                //     layer.msg('角色名称不能为空~', {icon: 5,time: 2500});
                //     return false;
                // }

                // return flag;
            },
            pushData:function(){
                var dom = this.dom;
                var ids = [];
                var role_id = $('input[name="role_id"]').val();
                var data = {
                    role_id:role_id,
                    _token:dom._token,
                    permissions_ids : ''
                }
                $.each($('#treeDemo').find('.chk'),function(index,item){
                    if($(item).hasClass('checkbox_true_part')||$(item).hasClass('checkbox_true_full')){
                        var arr = $(item).attr('id').split('_');
                        ids.push(arr[1]);
                    }
                })
                data.permissions_ids = ids.join(',');

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