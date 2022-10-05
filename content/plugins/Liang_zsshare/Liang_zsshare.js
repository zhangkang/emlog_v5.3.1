// liang_zsshare 20141211
$(document).on('click', '.liang_zsshare', function(){
  var a = $(this),
  id = a.data('liang_zsshare');
  if(liang_zsshare_check(id)){
    alert('您已赞过本文！');
  }else{
    $.post('', {plugin: 'liang_zsshare', action: 'zsshare', id: id}, function(b){
      a.find('span').html(b);
      liang_zsshare_(a);
    });
  }
});
// 通过 cookie 判断是否赞过 指定文章
function liang_zsshare_check(id){
  return new RegExp('liang_zsshare_' + id +'=true').test(document.cookie);
}
// 已经赞过 设置 鼠标样式 及 title 提示文字
function liang_zsshare_(a){
  a.css('cursor', 'not-allowed').attr('title','您已赞过本文！');
}
//弹窗特效
	(function($){
	        $(function(){
	          $('[data-dialog]').on('click', function(e){
	            var $this = $(e.target);
	            $($this.data('dialog')).attr('class', 'popup '+$this.data('effect'));
	          });
	        });
	      })(jQuery);
	  $(document).ready(function(){
	    $('.popup').popup({
	      close: function(){
	        $(this).find('.embed-container').empty();
	      }
	    });
	  });
// 百度分享
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];