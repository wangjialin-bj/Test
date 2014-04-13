<?php
    if(C('LAYOUT_ON')) {
        echo '{__NOLAYOUT__}';
    }
?>
<extend name="Base/common" />


<block name="body">
<div class=container>
	<div class=row>
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="well well-large" style="margin-top:150px;margin-bottom:200px;">
			<present name="message">
			<h1>:)</h1>
			<p class="success"><h3><?php echo($message); ?></h3></p>
			<else/>
			<h1>:(</h1>
			<p class="error"><h3><?php echo($error); ?></h3></p>
			</present>
			<p class="detail"></p>
			<p class="jump">
            <h4>Page automatically <a id="href" href="<?php echo($jumpUrl); ?>">jump</a> Waiting time： <b id="wait"><?php echo($waitSecond); ?></b>
			</h4></p>
		</div>
		</div>
		<div class="col-md-3"></div>
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

