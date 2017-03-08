<?php

$option_contact = array(
	'Sample Request' => 'Sample Request',
	'Estimate Request' => 'Estimate Request',
	'Other' => 'Other'
);
$attributes_contact = array(
	'empty' => 'Select Contact type',
	'class' => 'placeholder',
	'id' => 'contacttype'
);
if ($contacttype_style) {
	$attributes_contact['style'] = 'color: rgb(0, 0, 0);';
}

if ($contacttype_error) {
	$attributes_contact['class'] = 'error';
}
$options_contactdetail = array(
	'required' => false
);
if ($contactdetail_error) {
	$options_contactdetail['class'] = 'error';
}
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
</head>

<body class="fade">
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/analytics.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/header_form.php'); ?>



<div class="position">
<ol>
<li class="current"><span>Input</span></li><!--
--><li><span>Confirm</span></li><!--
--><li><span>Complete</span></li>
</ol>
</div>


<article class="content account">
<form action="/contact/confirm" method="POST">

<section>
<h2>Contact</h2>
</section>

<section>
<?php if ($products_error) { ?>
<p class="error">* Please select products.</p>
<?php } ?>
<p class="selectp"><span>Select products</span>
<span class="plist <?php if ($products_error) echo 'error'; ?>">
<?php echo $product_checkbox; ?>
</span></p>
<?php if ($contacttype_error) { ?>
<p class="error">* <?php echo $contacttype_error; ?></p>
<?php } ?>
<?php if ($contactdetail_error) { ?>
<p class="error">* <?php echo $contactdetail_error; ?></p>
<?php } ?>
<p><span>Contact type</span><label class="select"><!--
--><?php echo $this->Form->select('Contact.contacttype', $option_contact, $attributes_contact); ?>
</label><!--
--></p>
<p class="contactdetail"><?php echo $this->Form->textarea('Contact.contactdetail', $options_contactdetail); ?></p>
</section>

<section class="confirmterm">
<div>
<p><strong>Please carefully read the following Privacy Policy and Terms of Use before your submission:</strong></p>
<ul>
<li><a href="/policy/" target="_blank">Privacy Policy</a></li>
<li><a href="/terms/" target="_blank">Terms of Use</a></li>
</ul>
<p class="agreebox"><span><label for="agree" class="checkbox"><input type="checkbox" id="agree" class="checkbox" value="agree">I understand and agree to Privacy Policy and Terms of Use.</label></span></p>
</div>
</section>

<section class="btn mt-2rem" id="inquiry">
<input type="button" onClick="location.href='/'" id="cancel2" class="btn" value="Cancel">
<span class="arrowbtn2"><input type="submit" id="confirm" name="confirm" class="btn disabled" value="Confirm" disabled></span>
</section>

</form>
</article>



<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
</body>
</html>