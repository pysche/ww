<?php
header('Content-Type:text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>运费计算器</title> 
<meta http-equiv='X-UA-Compatible' content='IE=EmulateIE7' /> 
<style type='text/css'>
body {
	color: #000;
	font-size: 14px;
	font-family: tahoma, "宋体";
}

#wrap {
	margin: 20px 60px auto;
	width: 400px;
}

input {
	font-family: tahoma, "宋体";
}

input.ip {
	border: 1px solid #000;
}

#wrap li {
	list-style: none;
}

div#btns {
	text-align: center;
}

div#result {
	display: none;
	border: 1px dotted #f90;
	padding: 10px;
	margin: 10px 0px 0px 0px;
}

fieldset {
	padding: 20px;
}

div#copy {
	text-align: center;
}

</style>
<script type='text/javascript' src='js/jquery-1.4.2.min.js'></script>
</head>


<body>
<div id='wrap'>
	<form id='calculator'>
		<fieldset>
			<legend>运费计算器</legend>
			<ul>
				<li>商品价格：<input type='text' class='ip' id='price' name='price' value='' /></li>
				<li>网站运费：<input type='text' class='ip' id='dollars' name='dollars' value='' /></li>
				<li>重量：<input type='text' class='ip' id='weight' name='weight' value='' /></li>
			</ul>
			<div id='btns'>
				<input type='button' id='go' name='go' value='计算(s)' accesskey='s' class='ip btn' />
			</div>
			<div id='result'>
				<div id='disp'>
				
				</div>
				<div id='copy'>
					<input type='button' id='copy' name='copy' value='拷贝到剪贴板(c)' class='ip btn' />
				</div>
			</div>
		</fieldset>
	</form>
</div>

<script type='text/javascript'>
$(function(){
	$('#price').focus();
	
	$('#go').click(function(){
		d = '';
		price = $.trim($('#price').val());
		dollars = $.trim($('#dollars').val());
		weight = $.trim($('#weight').val());
		pat = /^([0-9\.]+)$/;
		
		if (!pat.test(price)) {
			alert('商品价格不是数字？');
		} else if (!pat.test(dollars)) {
			alert('网站运费不是数字？');
		} else if (!pat.test(weight)) {
			alert('重量不是数字？');
		} else {
			total = 0;
			weight_money = 0;
			
			total += price*7.5 + dollars*7;
			weight_money += 90;
			
			if (weight>1) {
				delta = weight - 1;
				deltaInt = parseInt(delta);
				weight_money += deltaInt*90;
				
				if ((delta - deltaInt)==0) {
					weight_money +=0;
				} else if ((delta - deltaInt)<=0.5) {
					weight_money += 50;
				} else {
					weight_money += 90;
				}
			}
			
			total += weight_money;
			
			tmp = parseInt(total);
			
			if (total-tmp>0.5) {
				total = tmp+1;
			} else {
				total = tmp;
			}
			
			str = '到手价格：{PRICE}×7.5+{DOLLARS}×7（网站运费）+国际国内运费（暂时按{WEIGHT}磅估算为{WEIGHT_MONEY}，等货品收到后按实际重量计费）={TOTAL}元';
			str = str.replace('{PRICE}', price).replace('{DOLLARS}', dollars).replace('{WEIGHT}', weight).replace('{WEIGHT_MONEY}', weight_money).replace('{TOTAL}', total);
			
			$('#result').show();
			$('#disp').text(str);
		}
		
	});
	
	$('#copy').click(function(){
	    if (window.clipboardData) {  
			window.clipboardData.setData("Text",$('#disp').text());  
		}  
	});
});
</script>
</body>

</html>
