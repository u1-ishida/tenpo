<?php
extract($contact_data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/head.php'); ?>

<title>Contact | NAGASE Personal Care</title>

<!-- unique // -->
<link rel="stylesheet" href="/common/account/css/style.css">
<script src="/common/js/form.js"></script>
<meta name="robots" content="noindex,nofollow">
<!-- // unique -->
<script type="text/javascript">
function input_back() {
	var target = document.getElementById("form_complete");
	target.action = "/contact/input";
	target.submit();
}
function complete() {
	var target = document.getElementById("form_complete");
	target.submit();
}
</script>
</head>

<body class="fade">
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/analytics.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/header_form.php'); ?>



<div class="position fade">
<ol>
<li><span>Input</span></li><!--
--><li class="current"><span>Confirm</span></li><!--
--><li><span>Complete</span></li>
</ol>
</div>



<article class="content account">
<form id="form_complete" action="/contact/complete" method="POST">
<input type="hidden" name="mode" value="confirm">
<input type="hidden" name="products_value" value="<?php echo $products_value; ?>">
<input type="hidden" name="contacttype" value="<?php echo $contacttype; ?>">
<input type="hidden" name="contactdetail" value="<?php echo $contactdetail; ?>">

<section>
<h2>Contact</h2>
</section>

<section class="mt-2rem">
<p class="selectp"><span>Select products</span>
<span class="plistconfirm">
<?php echo $products; ?>
</span></p>
<p><span>Contact type</span><?php echo $contacttype; ?></p>
<p class="contactdetailconfirm"><?php echo nl2br(htmlspecialchars($contactdetail)); ?></p>
</section>

<section class="btn mt-2rem" id="inquiry">
<input type="button" onClick="input_back();" name="back" id="back2" class="btn" value="Back">
<span class="arrowbtn3"><input type="submit" name="complete" id="compform" class="btn" value="Submit"></span>
</section>

</form>
</article>



<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
</body>
</html>