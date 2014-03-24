$(function(){
	//图标隐藏菜单
	$(".entrance").hover(function(){
		$(this).children(".user-menu").show();
	},function(){
		$(this).children(".user-menu").hide();
	});

	$('.action .detailed').each(function(){
		$(this).click(function() {
        	detailed_content();
        	return false;
        });
  	});

	$('.action .thinkbox-image').each(function(){
		$(this).click(function() {
        	thinkbox_image();
        	return false;
        });
  	});

    //表单验证试验
    $(".demoform").Validform({
        btnSubmit:"#changepwd_btns",
        btnReset:"#changepwd_resets",
        tiptype:function(msg,o,cssctl){

            //msg：提示信息;
            //o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
            //cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
            if(!o.obj.is("form")){//验证表单元素时o.obj为该表单元素，全部验证通过提交表单时o.obj为该表单对象;
                var objtip=o.obj.siblings(".Validform_checktip");
                cssctl(objtip,o.type);
                objtip.text(msg);
            }else{
                var objtip=o.obj.find("#msgdemo");
                cssctl(objtip,o.type);
                objtip.text(msg);
            }
        },
        ajaxPost:true
    });


    $('#changepwd_btn').click(function()
	{
		$.post('index.php?s=/Home/User/changepwd', $('#form1').serialize(),function(data){
			edit_success(data);
		});
		function edit_success(data){
				bootbox.dialog({
					message: '密码修改成功',
					backdrop: 'static',
					closeButton: false,
					animate: true,
					className: "ot-dialog"
				});
				var tpl = $("<span class='glyphicon glyphicon-ok-circle ot_collect_icon'></span>");
	            setTimeout(function(){
	                var div = $(".ot-dialog .bootbox-body");
	                div.append(tpl);
	            },200);
				setTimeout(function(){
					location.reload()
				},2200);
			}
	})
	(function(){
		var $nav = $("#nav"), $current = $nav.children("[data-key=" + $nav.data("key") + "]");
		if($nav.length){
			$current.addClass("current");
		} else {
			$("#nav").children().first().addClass("current");
		}
	})();

});
