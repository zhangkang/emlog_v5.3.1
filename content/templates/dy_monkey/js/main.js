/*
* 	main.js 
*  	程序主要的js
*
*/


//获取QQ信息
function huoquqq() {
	$('#loging').html('<img src="https://api.dyboy.cn/static/img/loadqq.gif"><a style="font-size:12px;margin-left:5px;">\u6b63\u5728\u83b7\u53d6QQ\u4fe1\u606f..</a>');
	var urls = window.location.href;
	$.ajax({
		url: urls,
		type: "POST",
		data: {
			"qq": $('#qqnum').val()
		},
		dataType: "html",
		success: function(c) {
			var josn = eval("" + c.split('@@')[1].split('@@')[0] + "");
			$('#loging').html("");
			$('#comname').val(josn.comname);
			$('#commail').val(josn.commail);
			$('#comurl').val(josn.comurl);
			$('#comment').focus();
		}
	});
}

//ajax评论
function comment(){
	//评论提示
    $("#comment").focus(function(){
    	 $(".com_tips").text("感谢您的金玉良言~");
    });
    $("#comment").blur(function(){
    	 $(".com_tips").text("用心评论收获价值~");
    });
    
	$("#commentform").on("submit",function() {
		event.preventDefault();
        if($("#comment").val()==""){
            alert("亲，请填写恰当的评论内容哦~");
        }
        var a = $("#commentform").serialize();
        $.ajax({
            type: 'POST',
            url: $("#commentform").attr("action"),
            data: a,
			async:false,	// 同步
            success: function(a) {
                $(".com_tips").text("感谢您的金玉良言~");
                if($(".com_tips").text()=="感谢您的金玉良言~"){
                    $.pjax.reload('#monkey_pjax', {fragment: '#monkey_pjax',timeout: 8000})
                }
            }
        });
        $(".com_tips").text("啊哦~评论功能好像被你弄坏了~");
        return false;
    });
}

function search(){
	$(".search_input").blur(function(){
		var search_val = $(".search_input").val();
		$(".search_a_btn").attr('href','./index.php?keyword='+search_val);
	})
}


$(document).ready(function(){

	// 代码美化输出
	if( $('pre').length ){
	    prettyPrint();
	}

	// 搜索
	search();

	// 导航栏图标控制
	$('div.burger').click( function () {
	    if (!$(this).hasClass('open')) {
	        openMenu();
	    } else {
	        closeMenu();
	    }
	});

	//菜单展开 动画
	function openMenu() {
	    $('div.burger').addClass('open');
	    $('div.y').fadeOut(100);
	    $('div.screen').addClass('animate');
	    setTimeout(function () {
	        $('div.x').addClass('rotate30');
	        $('div.z').addClass('rotate150');
	        $('.menu').addClass('animate');
	        setTimeout(function () {
	            $('div.x').addClass('rotate45');
	            $('div.z').addClass('rotate135');
	        }, 100);
	    }, 10);
	}

	//菜单关闭 动画
	function closeMenu() {
	    $('div.screen, .menu').removeClass('animate');
	    $('div.y').fadeIn(150);
	    $('div.burger').removeClass('open');
	    $('div.x').removeClass('rotate45').addClass('rotate30');
	    $('div.z').removeClass('rotate135').addClass('rotate150');
	    setTimeout(function () {
	        $('div.x').removeClass('rotate30');
	        $('div.z').removeClass('rotate150');
	    }, 50);
	    setTimeout(function () {
	        $('div.x, div.z').removeClass('collapse');
	    }, 70);
	}

	//导航栏一级目录伸缩
	$(".burger").click(function(){
		$(".bar").slideToggle(500);
	});
	
	//导航栏二级菜单伸缩
	$(".common").click(function(){
		$(this).children("ul.sub-nav").slideToggle(500);
		$(this).siblings(".common").children("ul.sub-nav").slideUp(500);
	});

	//到顶部
	$("#to_top").click(function() {
	    $("html,body").animate({scrollTop:0}, 500);
	 });

	//浮层看图
	$("img[src$=jpg],img[src$=jpeg],img[src$=png],img[src$=gif]").parent("a[class!=noview]").addClass("swipebox");
	jQuery(function($) { $(".swipebox").swipebox(); });

    comment();
})
