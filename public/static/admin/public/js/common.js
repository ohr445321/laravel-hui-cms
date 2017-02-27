
// 关闭Iframe弹框窗口
$(document).on('click', '.close-iframe', function () {
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
});

$("#refresh_wrapper").click(function(){
    var $current_iframe=$(".Hui-article-box iframe:visible");
    console.log($current_iframe);
    $current_iframe[0].contentWindow.location.reload();
    return false;
});

$('.menu_dropdown li a').on('click',function(){
    $('.menu_dropdown li').removeClass('active');
    $(this).parent('li').addClass('active');
})