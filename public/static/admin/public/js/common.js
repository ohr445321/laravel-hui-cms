;(function () {
	// 关闭Iframe弹框窗口
	$(document).on('click', '.close-iframe', function () {
	    var index = parent.layer.getFrameIndex(window.name);
	    parent.layer.close(index);
	});

	//右上角刷新内嵌iframe事件
	$("#refresh_wrapper").click(function(){
	    var $current_iframe=$(".Hui-article-box iframe:visible");
	    $current_iframe[0].contentWindow.location.reload();
	    return false;
	});

	//侧边栏点击事件
	$('.menu_dropdown li a').on('click',function(){
	    $('.menu_dropdown li').removeClass('current');
	    $(this).parent('li').addClass('current');
	})

})()


/**
 * 地址参数——?type=1&id=2   转为json——{type:1,id:2}
 * 
 * @param url
 */
function paramsToJson(url){
     var theRequest = new Object();
     if (url.indexOf("?") != -1) {
      var str = url.substr(1);
      strs = str.split("&");
      for(var i = 0; i < strs.length; i ++) {
       theRequest[strs[i].split("=")[0]]=(strs[i].split("=")[1]);
      }
     }
     return theRequest;
}


/**
 * 参数——str 判断是否为空
 * 
 * @param str
 */
function isNull( str ){ 
    if ( str == "" ) {
        return true;
    }
    var regu = "^[ ]+$"; 
    var re = new RegExp(regu); 
    return re.test(str);
}

/**
 * 模板渲染 example--<li>@key@</li> key为obj里面的数据
 * 
 * @param obj--数据
 */
String.prototype.template = function(obj){
    return this.replace(/\@\w+\@/g,function(matches){
        var temp = obj[matches.replace(/\@/g,'')];
        return (temp+'')==undefined?'':temp;
    })
}


//参数为两个构造函数 实现原型链的继承
function inheritObj(sub,sup){
    var proto = Object(sup.prototype);
    proto.constructor = sub;
    sub.prototype = proto;
}


