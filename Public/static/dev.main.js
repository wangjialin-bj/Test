//jquery
$(function()
{
    //切换语言
    $('#changeLanguageStatus').change(function(){
        $.post('index.php?s=/Home/Index/changeLanguage',
            {lang:$(this).val() , time:new Date().getTime()},
            function(msg){
                if(msg){
                    redirect('index.php?s=/Home/Index/Index');
                }
            });
    })
    $('.message_list').mouseover(function(){
        $(this).css({'background':'#eee'});
    }).mouseout(function()
    {
        $(this).css({'background':'#fff'});
    })

    //全部标记为已读
    $('.clear_all_message a').click(function()
    {
    	$.post('index.php?s=/Home/Message/changeAllMessageStatus' ,null ,
    		function(msg)
    		{
    			if(msg == 1)
    			{
    				//提示信息
					$('#show_alert').find('span').text('删除成功！');
					$('#show_alert').addClass('alert-success').show();
					setTimeout(function()
					{
						$('#contents').html("<div class='lead'>暂无未读信息</div>");
						$('#message_number').hide();
					},1000);
    			}
    			else
    			{
    				alert('标记失败，请稍后再试！');
    			}
    		})
    });
 /*购物车 jq脚本 开始*/
    //全选购物车商品
    $(".check_all_goods").click(function(){
        $(".ids").prop("checked", this.checked);
    });
    $(".ids").click(function(){
        var option = $(".ids");
        option.each(function(i){
            if(!this.checked){
                $(".check_all_goods").prop("checked", false);
                return false;
            }else{
                $(".check_all_goods").prop("checked", true);
            }
        });
    });
    //删除购物车商品
    $('#delAllGoods').click(function()
    {
        var option = $(".ids");
        var goods_ids = ''
        option.each(function(i){
            if(this.checked)
            {
                goods_ids += this.value + "#";
            }
        });
        $.post('index.php?s=/Home/Goods/delGoodsIdsInfo' ,
            {goods_ids : goods_ids},
            function(msg){
                var data = eval('('+msg+')');
                var _last = 0;
                if(!data.total_price){
                    _last = 1;
                    if(data.info == 'empty'){
                        show_alert('show_alert','alert-success','购物车中无商品，请继续购物！',1000);
                        $('.table_tbody tr:not(:last)').remove();
                        $('.total_price').text(0);
                        $('.table_tbody').prepend("<tr><td colspan='7'>暂无商品，请继续<a href='index.php?s=/Home/Goods/Goodslist'>购物</a></td></tr>");
                        return false;
                    }
                    show_alert('show_alert','alert-success','删除失败，请刷新页面再尝试！',1000);
                    return false;
                }
                if(!_last){
                    var ids = data.goods_ids;
                    $('.total_price').text(data.total_price);
                    show_alert('show_alert','alert-success','删除成功！',1000);
                    var arr = ids.split('#');
                    for( i in arr)
                    {
                        $('#goods_'+arr[i]).remove();
                    }
                }
                _last = 0
            }
        );
    });
    $('.number_add_btn').click(function()
    {
        var obj = $(this).parent().parent();
        var number = obj.find('.number_input').val();
        if(parseInt(number) < 100)
        {
            obj.find('.number_input').val(parseInt(number) + 1);
            var _tr = $('#goods_'+$(this).attr('goods_id'));
            var goods_id = $(this).attr('goods_id');
            var type = $(this).attr('type');
            $.post("index.php?s=/Home/Goods/changePriceStatus",
              {goods_id:goods_id,type:type},
              function(msg){
                var data = eval('('+msg+')');
                if(!data.goods_all_price){
                  if(data.info && !data.old)
                  {
                    _tr.find('.number_input').val(_tr.find('.number_input').val() - 1);
                    show_alert('show_alert','alert-error',data.info+'!,请稍后再试！',1000);
                    return true;
                  }
                  alert('更改商品数量失败');
                  return false;
                }
                _tr.find('.all_price').text(data.goods_all_price);
                $('.total_price').text(data.total_price);
              })
        }else{
            show_alert('show_alert' , 'alert-error' ,'最多不能超过100个商品' ,1000);
        }
    })

    $('.number_del_btn').click(function()
    {
        var obj = $(this).parent().parent();
        var number = obj.find('.number_input').val();
        if(parseInt(number) > 1)
        {
            obj.find('.number_input').val(parseInt(number) - 1);
            var _tr = $('#goods_'+$(this).attr('goods_id'));
            var goods_id = $(this).attr('goods_id');
            var type = $(this).attr('type');
            $.post("index.php?s=/Home/Goods/changePriceStatus",
              {goods_id:goods_id,type:type},
              function(msg){
                var data = eval('('+msg+')');
                if(!data.goods_all_price){
                     show_alert('show_alert' , 'alert-error' ,'更改商品数量失败' ,1000);
                     return false;
                }
                _tr.find('.all_price').text(data.goods_all_price);
                $('.total_price').text(data.total_price);
              })
        }else{
            show_alert('show_alert' , 'alert-error' ,'商品数量不能小余1' ,1000);
        }
    })

    //验证是否是数字
    $('.number_input').blur(function()
    {
        var number = $(this).val();
        if(!isInt(number)){
            show_alert('show_alert' , 'alert-error' ,'必须输入整数' ,1000);
            $(this).val(1);
        }
        if(parseInt(number) == 0)
        {
            show_alert('show_alert' , 'alert-error' ,'不能为0' ,1000);
            $(this).val(1);
        }
        var _tr = $('#goods_'+$(this).attr('goods_id'));
        var goods_id = $(this).attr('goods_id');
        var goods_account = $(this).val();
        var type = $(this).attr('change_type');
        $.post("index.php?s=/Home/Goods/changePriceStatus",
          {goods_id : goods_id , type:type ,goods_account : goods_account},
          function(msg)
          {
            var data = eval('('+msg+')');
            if(!data.goods_all_price){
              if(data.info && data.old)
                  {
                    _tr.find('.number_input').val(data.old);
                    $('.total_price').text(data.price);
                    show_alert('show_alert' , 'alert-error' ,data.info ,1000);
                    return true;
                  }
                show_alert('show_alert' , 'alert-error' ,'更改商品数量失败' ,1000);
                return false;
            }
            _tr.find('.all_price').text(data.goods_all_price);
            $('.total_price').text(data.total_price);
          }
        );
    });
 /*购物车 jq脚本 结束*/
});

//javascript
function dialog(show_id , title , content , fun , width , height , button1, button2)
{
	if(!show_id)
	{
		show_id = 'dialog';
	}
	width = width ? width : 350;
	height = height ? height :200;

	if(button1 && button2){
		$('#'+show_id).dialog({
		title:title,
	    width: width,
	    height: height,
	    autoOpen: true,
	    modal: true,
	    buttons: {
	        '确定': function () {
	        	if(fun)
	        	{
	        		eval(fun);
	        	}
	            $(this).dialog("close");
	        },
	        '取消': function () {
	            $(this).dialog("close");
	        }
	    }
		});
	}else{
		$('#'+show_id).dialog({
		title:title,
	    width: width,
	    height: height,
	    autoOpen: true,
	    modal: true,
		});
	}
	if(content)
	{
		$('#'+show_id).html(content);
	}
	return false;
}

function message_del(message_id)
{
	if(message_id)
	{
		dialog('dialog_message' , '提示' , print_var['L_SUCCESS_INFO'] ,'delMessage('+message_id+')',350,200);
	}
}

function delMessage(message_id)
{
	$.ajax({
		url:"index.php?s=/Home/Message/delMessage",
		type:'post',
		data:{mid:message_id},
		success:function(msg)
		{
			if(msg == 1)
			{
				$('#message_'+message_id).fadeOut();
				$('#message_'+message_id).remove();
				var old_number = $('#message_number').text();
				var new_number = Number(old_number) - 1;
				$('#message_number').text(new_number);

				//提示信息
				show_alert('show_alert','alert-success','删除成功！',1000);
				//全部删除后显示提示信息
				if($('.message_list').length == 0)
				{
					$('#contents').html("<div class='lead'>暂无已读信息</div>");
				}
			}
			else
			{
				show_alert('show_alert','alert-error','删除已读信息出错，请刷新页面再试！',1000);
			}
		}
	})
}
function message_read(message_id)
{
	if (!message_id) {alert('error!');return;};
	$.ajax({
		url:"index.php?s=/Home/Message/changeMessageStatus",
		type:'post',
		data:{mid:message_id},
		success:function(msg)
		{
			if(msg == 1)
			{
				$('#message_'+message_id).fadeOut();
				$('#message_'+message_id).remove();

				var old_number = $('#message_number').text();
				var new_number = Number(old_number) - 1;
				$('#message_number').text(new_number);
				//提示信息
				show_alert('show_alert','alert-success','标记成功！',1000);

				//全部删除后显示提示信息
				if($('.message_list').length == 0)
				{
					$('#contents').html("<div class='lead'>暂无未读信息</div>");
				}
			}
			else
			{
				show_alert('show_alert','alert-error','标记未读信息出错，请刷新页面再试！',1000);
			}
		}
	})
}

// 显示提示信息函数 需要依赖 div class=alert
function show_alert(show_id , type , content, time)
{
	var show_id = show_id ? show_id : 'show_alert';
	var type = type ? type : 'alert-success';
	var content = content ? content : '';
	var time = time ? time :1000;

	$('#'+show_id).find('span').text(content);
	$('#'+show_id).addClass(type).show();

	setTimeout(function()
	{
		$('#'+show_id).fadeOut();
	},time);
}

function test_dialog()
{
	alert('函数执行成功！');
}

//显示意见反馈的界面
function feed_form()
{
	dialog('feedback_form1' , '留下您的意见或反馈' , '' ,'',600,480);
}

/*提交反馈意见*/
function sendFeedback()
{
	var email = $('#feedback_form1').find('input[name="email"]').val();
	var content = $('#feedback_form1').find('textarea').val();
	var name = $('#feedback_form1').find('input[name="name"]').val();
	if(email == '' || content == '' || name =='')
	{
		$('#feed_form_tips').html('<font color=red><b>内容不能为空</b></font>');
		return false;
	}
	$('#feed_form_tips').html('正在提交...');
	$.post('index.php?s=/Home/Index/addFeedback' ,
		{email : email , content:content , name:name},
		function(msg){
			if(msg != 1)
			{
				//格式化错误信息
				var str = showErrorStr(msg);
				$('#feed_form_tips').html('<font color=red><b>'+str+'</b></font>');
				//自动跳转
				if(msg == 2){
					redirect('index.php?s=/Home/User/login' , 1000);
				}
				return false;
			}
			//提示
			$('#feed_form_tips').html('<font color=blue><b>提交成功！回复信息将以邮件发送</b></font>');
			redirect('index.php?s=/Home/Index' , 2000);
		});
}

//错误提示
/*
* num error
*  0   数据库写入失败
*  2   用户未登录
*/
function showErrorStr(num)
{
	var str = '';
	switch(Number(num))
	{
		case 2:
			str = '请登录后再发送反馈！';
			break;
		case 0:
			str = '提交失败！请输入正确的格式';
			break;
		default:
			str = '参数错误';
			break;
	}
	return str;
}

//定时跳转，不输入time则默认直接跳转
function redirect(url , time)
{
	if(!url) return false;
	var time = time ? Number(time) : 0;
	setTimeout(function(){window.location.href = url;} , time);
}

function isInt(intValue){
	var intPattern=/^0$|^[1-9]\d*$/; //整数的正则表达式
	result=intPattern.test(intValue);
	return result;
}

//goods商品操作 获取多个商品的总价格
function getTotalPrice(price , number ,tr)
{
}

//添加信息到购物车
function addGoodsCart(goods_id , goods_name , goods_price ,obj)
{
	var _obj = $(obj);
	_obj.parent().find('span').show();
	_obj.hide();

	if(!goods_id || !goods_price || !goods_name)
	{
		return false;
	}
	$.post
	(
		'index.php?s=/Home/Goods/addGoodsCart' ,
		{
			goods_id : goods_id ,
			goods_name : goods_name,
			goods_price : goods_price ,
			time : Math.random()
		} ,
		function(msg){
			if(msg != 1)
			{
				alert('加入购物车失败');
			}
			alert('加入购物车成功！');
			_obj.parent().find('span').hide();
			_obj.show();
		}
	)
}

//单挑删除购物车商品信息提示
function delGoodsInfoAction(goods_id)
{
    if(goods_id)
    {
        dialog('dialog_goods' , '提示' , '<center style="margin-top:30px;"><h4>'+print_var['L_NOTICE_DEL']+'</h4></center>' ,'delGoodsInfo('+goods_id+')',350,200 ,'button1' , 'button2');
    }else{
        //show_alert();
    }
}

//删除购物车的一条信息
function delGoodsInfo(goods_id)
{
	if(!goods_id)
	{
		return false;
	}
    var _goods_id = goods_id;
    var _last = 0;
	$.post("index.php?s=/Home/Goods/delGoodsInfo",
	{goods_id : goods_id},
		function(msg){
			var data = eval('('+msg+')');
			if(!data.total_price){
                _last = 1;
				if(data.info == 'empty'){
                    show_alert('show_alert','alert-success','购物车中无商品，请继续购物！',1000);
					$('#goods_'+_goods_id).fadeOut();
                    $('.total_price').text(0);
                    $('.table_tbody').prepend("<tr><td colspan='7'>暂无商品，请继续<a href='index.php?s=/Home/Goods/Goodslist'>购物</a></td></tr>");
					return false;
				}
                show_alert('show_alert','alert-success','删除失败，请刷新页面再尝试！',1000);
				return false;
			}
            if(!_last){
    			$('.total_price').text(data.total_price);
                show_alert('show_alert','alert-success','删除成功！',1000);
                $('#goods_'+_goods_id).fadeOut();
            }
		}
	)
}