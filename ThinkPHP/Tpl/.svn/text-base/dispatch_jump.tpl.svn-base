<?php
    if(C('LAYOUT_ON')) {
        echo '{__NOLAYOUT__}';
    }
?>
<extend name="Base/common" />


<block name="body">


<div class=container>
	<div class=row>
		<div class=span3></div>
		<div class=span6>
			<div class="well well-large" style="margin-top:150px;margin-bottom:200px;">
			<present name="message">
			<h1>:)</h1>
			<p class="success"><?php echo($message); ?></p>
			<else/>
			<h1>:(</h1>
			<p class="error"><?php echo($error); ?></p>
			</present>
			<p class="detail"></p>
			<p class="jump">
			页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
			</p>
		</div>
		</div>
		<div class=span3></div>
	</div>
</div>

</block>

<block name="side"> </block>
<block name="script">
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</block>

