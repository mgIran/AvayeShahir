<?php
/* @var $Amount double */
/* @var $ResNum string */
/* @var $MID string */
/* @var $callbackUrl string */
?>
<script language="javascript" type="text/javascript">
	function postRefId (Amount, ResNum, MID, RedirectURL) {
		var form = document.createElement("form");
		form.setAttribute("method", "POST");
		form.setAttribute("action", "https://fcp.shaparak.ir/_ipgw_//payment/simple/");
		form.setAttribute("runat", "server");
		form.setAttribute("target", "_self");

		var hiddenField;
		hiddenField = document.createElement("input");
		hiddenField.setAttribute("name", "Amount");
		hiddenField.setAttribute("value", Amount);
		form.appendChild(hiddenField);

		hiddenField = document.createElement("input");
		hiddenField.setAttribute("name", "ResNum");
		hiddenField.setAttribute("value", ResNum);
		form.appendChild(hiddenField);

		hiddenField = document.createElement("input");
		hiddenField.setAttribute("name", "MID");
		hiddenField.setAttribute("value", MID);
		form.appendChild(hiddenField);

		hiddenField = document.createElement("input");
		hiddenField.setAttribute("name", "RedirectURL");
		hiddenField.setAttribute("value", RedirectURL);
		form.appendChild(hiddenField);

		document.body.appendChild(form);
		form.submit();
		document.body.removeChild(form);
	}
	postRefId('<?php echo $Amount; ?>', '<?php echo $ResNum; ?>', '<?php echo $MID; ?>', '<?php echo $callbackUrl; ?>');
</script>
<div class="row-fluid">
	<div class="span12">
		<div class="alert alert-info text-center" style="height: 400px">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong><?php echo Yii::t('rezvan', 'Transfer to the Portal Bank'); ?></strong>
            <br>
			<?php echo Yii::t('rezvan', 'You will be transferred to the bank site...'); ?>
			<br>
		</div>
	</div>
</div>
