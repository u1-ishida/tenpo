<?php
extract($account_data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/head.php'); ?>

<title>Registration | NAGASE Personal Care</title>

<!-- unique // -->
<link rel="stylesheet" href="/common/account/css/style.css">
<script src="/common/js/form.js"></script>
<meta name="robots" content="noindex,nofollow">
<!-- // unique -->
<script type="text/javascript">
function input_back() {
	var target = document.getElementById("form_complete");
	target.action = "/account/create/input";
	target.submit();
}
function complete() {
	var target = document.getElementById("form_complete");
	target.submit();
}
</script>
</head>

<body>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/analytics.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/header_form.php'); ?>



<div class="position mb-0 nobg">
<ol>
<li><span>Introduction</span></li><!--
--><li><span>Input</span></li><!--
--><li class="current"><span>Confirm</span></li><!--
--><li><span>Complete</span></li>
</ol>
</div>



<h2 class="content"><span>Registration</span></h2>



<article class="content account">
<form id="form_complete" action="/account/create/complete" method="POST">
<input type="hidden" name="mode" value="confirm">
<input type="hidden" name="salutation" value="<?php echo $salutation; ?>">
<input type="hidden" name="name1" value="<?php echo htmlspecialchars($name1); ?>">
<input type="hidden" name="name2" value="<?php echo htmlspecialchars($name2); ?>">
<input type="hidden" name="email" value="<?php echo $email; ?>">
<input type="hidden" name="password" value="<?php echo $password; ?>">
<input type="hidden" name="company" value="<?php echo htmlspecialchars($company); ?>">
<input type="hidden" name="companywebsite" value="<?php echo htmlspecialchars($companywebsite); ?>">
<input type="hidden" name="businesstype" value="<?php echo $businesstype; ?>">
<input type="hidden" name="otherbusinesstype" value="<?php echo htmlspecialchars($otherbusinesstype); ?>">
<input type="hidden" name="position" value="<?php echo htmlspecialchars($position); ?>">
<input type="hidden" name="tel" value="<?php echo htmlspecialchars($tel); ?>">
<input type="hidden" name="country" value="<?php echo htmlspecialchars($country); ?>">
<input type="hidden" name="othercountry" value="<?php echo htmlspecialchars($othercountry); ?>">
<input type="hidden" name="products_value" value="<?php echo $products_value; ?>">
<input type="hidden" name="contacttype" value="<?php echo $contacttype; ?>">
<input type="hidden" name="contactdetail" value="<?php echo htmlspecialchars($contactdetail); ?>">

<section>
<h2>Create new account</h2>
</section>

<section>
<p><span>Salutation</span><?php echo $salutation; ?></p>
<p class="inputname"><span>Name</span><?php echo $name1; ?> <?php echo $name2; ?></p>
<p><span>Email</span><?php echo $email; ?></p>
<p><span>Password</span>**********</p>
<p><span>Company</span><?php echo $company; ?></p>
<p><span>Company's Website (optional)</span><?php echo $companywebsite; ?></p>
<p><span>Business type</span><?php echo $businesstype; ?><?php if ($businesstype == "Other") echo ": $otherbusinesstype"; ?></p>
<p><span>Position (optional)</span><?php echo $position; ?></p>
<p><span>Telephone</span><?php echo $tel; ?></p>
<p><span>Country</span><?php echo $country; ?><?php if ($country == "Other") echo ": $othercountry"; ?></p>
</section>

<section class="mt-2rem">
<h2>Product inquiry (optional)</h2>
<p class="selectp"><span>Select products</span>
<span class="plistconfirm">
<?php echo $products; ?>
</span></p>
<p><span>Contact type</span><?php echo $contacttype; ?></p>
<p class="contactdetailconfirm"><?php echo nl2br(htmlspecialchars($contactdetail)); ?></p>
</section>

<section class="btn mt-2rem" id="account">
<input type="button" onClick="input_back();" name="back" id="back2" class="btn2" value="Back">
<span class="arrowbtn2"><input type="submit" name="complete" id="compform" class="btn" value="Submit"></span>
</section>

</form>
</article>



<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
</body>
</html>