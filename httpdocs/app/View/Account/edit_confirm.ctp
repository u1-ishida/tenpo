<?php
extract($account_data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/head.php'); ?>

<title>Account information change | NAGASE Personal Care</title>

<!-- unique // -->
<link rel="stylesheet" href="/common/account/css/style.css">
<script src="/common/js/form.js"></script>
<meta name="robots" content="noindex,nofollow">
<!-- // unique -->
<script type="text/javascript">
function input_back() {
	var target = document.getElementById("form_complete");
	target.action = "/account/edit/input";
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
<form id="form_complete" action="/account/edit/complete" method="POST">
<input type="hidden" name="mode" value="confirm">
<input type="hidden" name="name1" value="<?php echo htmlspecialchars($name1); ?>">
<input type="hidden" name="name2" value="<?php echo htmlspecialchars($name2); ?>">
<input type="hidden" name="email" value="<?php echo $email; ?>">
<input type="hidden" name="company" value="<?php echo htmlspecialchars($company); ?>">
<input type="hidden" name="businesstype" value="<?php echo $businesstype; ?>">
<input type="hidden" name="otherbusinesstype" value="<?php echo htmlspecialchars($otherbusinesstype); ?>">
<input type="hidden" name="position" value="<?php echo htmlspecialchars($position); ?>">
<input type="hidden" name="tel" value="<?php echo htmlspecialchars($tel); ?>">
<input type="hidden" name="country" value="<?php echo $country; ?>">
<input type="hidden" name="othercountry" value="<?php echo htmlspecialchars($othercountry); ?>">

<section>
<h2>Account information change</h2>
</section>

<section>
<p class="inputname"><span>Name</span><?php echo $name1; ?> <?php echo $name2; ?></p>
<p><span>Email</span><?php echo $email; ?></p>
<p><span>Company</span><?php echo $company; ?></p>
<p><span>Business type</span><?php echo $businesstype; ?><?php if ($businesstype == "Other") echo ": $otherbusinesstype"; ?></p>
<p><span>Position (optional)</span><?php echo $position; ?></p>
<p><span>Telephone</span><?php echo $tel; ?></p>
<p><span>Country</span><?php echo $country; ?><?php if ($country == "Other") echo ": $othercountry"; ?></p>
</section>

<section class="btn mt-2rem" id="accountchange">
<input type="button" onClick="input_back();" name="back" id="back2" class="btn" value="Back">
<span class="arrowbtn3"><input type="submit" name="complete" id="compform" class="btn" value="Submit"></span>
</section>

</form>
</article>



<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
</body>
</html>