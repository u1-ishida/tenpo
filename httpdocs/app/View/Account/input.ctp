<?php
$option_contact = array(
	'Sample Request' => 'Sample Request',
	'Estimate Request' => 'Estimate Request',
	'Other' => 'Other'
);
$class = "placeholder";
if ($contacttype_error) $class = "placeholder error";
$attributes_contact = array(
	'empty' => 'Select Contact type',
	'class' => "$class",
	'id' => 'contacttype'
);

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
</head>

<body class="fade">
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/analytics.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/header_form.php'); ?>



<div class="position mb-0 nobg">
<ol>
<li><span>Introduction</span></li><!--
--><li class="current"><span>Input</span></li><!--
--><li><span>Confirm</span></li><!--
--><li><span>Complete</span></li>
</ol>
</div>



<h2 class="content"><span>Registration</span></h2>

<article class="content account">
<form action="/account/create/confirm" method="POST">

<section>
<h2>Create new account</h2>
</section>

<section>
<?php $class = " class='acchange'"; if ($salutation_error) { $class = " class='acchange error'"; ?>
<p class="error">* <?php echo $salutation_error; ?></p>
<?php } ?>
<p><span>Salutation</span><label class="select"><select name="data[Account][salutation]" id="salutation"<?php echo $class; ?>>
<option value="" class="placeholder">Select Salutation</option>
<?php echo $salutation_option; ?>
</select></label></p>

<?php $class1 = "inputtxt"; if ($name1_error) { $class1 = "inputtxt error"; } ?>
<?php $class2 = "inputtxt"; if ($name2_error) { $class2 = "inputtxt error"; } ?>
<?php $class = "inputtxt"; if ($name_error) { $class = "inputtxt error"; ?>
<p class="error">* <?php echo $name_error; ?></p>
<?php } ?>
<p class="inputname"><span>Name</span><?php echo $this->Form->text('Account.name1',array('required' => false, 'class' => "$class1", 'id' => 'name1', 'maxlength' => 80)); ?><?php echo $this->Form->text('Account.name2',array('required' => false, 'class' => "$class2", 'id' => 'name2', 'maxlength' => 80)); ?></p>
<?php $class = "inputtxt"; if ($email_error) { $class = "inputtxt error"; ?>
<p class="error">* <?php echo $email_error; ?></p>
<?php } ?>
<p><span>Email</span><?php echo $this->Form->text('Account.email',array('required' => false, 'class' => "$class", 'id' => 'email', 'maxlength' => 80)); ?></p>
<p class="notice">* Please use a valid business Email address.</p>

<?php $class = "inputtxt"; if ($password_error) { $class = "inputtxt error"; ?>
<p class="error">* <?php echo $password_error; ?></p>
<?php } ?>
<p><span>Password</span><?php echo $this->Form->password('Account.password',array('required' => false, 'class' => "$class", 'id' => 'password', 'maxlength' => 30)); ?></p>
<p class="notice">* Minimum of 8 characters</p>

<?php $class = "inputtxt"; if ($password2_error) { $class = "inputtxt error"; ?>
<p class="error">* <?php echo $password2_error; ?></p>
<?php } ?>
<p><span>Re-enter Password</span><?php echo $this->Form->password('Account.password2',array('required' => false, 'class' => "$class", 'id' => 'password2', 'maxlength' => 30)); ?></p>

<?php $class = "inputtxt"; if ($company_error) { $class = "inputtxt error"; ?>
<p class="error">* <?php echo $company_error; ?></p>
<?php } ?>
<p><span>Company</span><?php echo $this->Form->text('Account.company',array('required' => false, 'class' => "$class", 'id' => 'company', 'maxlength' => 80)); ?></p>
<?php $class = "inputtxt"; if ($companywebsite_error) { $class = "inputtxt error"; ?>
<p class="error">* <?php echo $companywebsite_error; ?></p>
<?php } ?>
<p><span class="fnt90">Company's Website<span class="optblock">(optional)</span></span><?php echo $this->Form->text('Account.companywebsite', array('required' => false, 'id'=>'companywebsite', 'class'=>"$class", 'maxlength' => 80)); ?></p>

<?php $class = ""; if ($businesstype_error) { $class = " class='error'"; ?>
<p class="error">* <?php echo $businesstype_error; ?></p>
<?php } ?>
<p><span>Business type</span><label class="select"><!--
--><select name="data[Account][businesstype]" id="businesstype"<?php echo $class; ?>>
<option value="">Select Business type</option>
<?php echo $bussness_type_option; ?>
</select>
<?php $class = "inputtxt other"; if ($otherbusinesstype_error) { $class = "inputtxt other error"; ?>
<p class="error">* <?php echo $otherbusinesstype_error; ?></p>
<?php } ?>
</label></p>

<p class="inputother" id="businesstypeother"<?php echo $businesstypeother_display; ?>>
<?php echo $this->Form->text('Account.otherbusinesstype', array('required' => false, 'class' => "$class", 'id' => 'otherbusinesstype', 'maxlength' => 80, 'placeholder' => 'Please enter your business type here')); ?>
</p>
</p>

<?php $class = "inputtxt"; if ($position_error) { $class = "inputtxt error"; ?>
<p class="error">* <?php echo $position_error; ?></p>
<?php } ?>
<p>
<span>Position (optional)</span><!--
--><?php echo $this->Form->text('Account.position',array('required' => false, 'class' => "$class", 'id' => 'position', 'maxlength' => 80)); ?><!--
--></p>

<?php $class = "inputtxt"; if ($tel_error) { $class = "inputtxt error"; ?>
<p class="error">* <?php echo $tel_error; ?></p>
<?php } ?>
<p><span>Telephone</span><?php echo $this->Form->tel('Account.tel',array('required' => false, 'class' => "$class", 'id' => 'tel', 'maxlength' => 80)); ?>
</p>

<?php $class = "placeholder"; if ($country_error) { $class = "placeholder error"; ?>
<p class="error">* <?php echo $country_error; ?></p>
<?php } ?>

<p><span>Country</span><label class="select"><!--
--><select name="data[Account][country]" class="<?php echo $class; ?>" id="country">
<option value="">Select Country</option>
<?php echo $country_option; ?>
</select>
<?php $class = "inputtxt other"; if ($othercountry_error) { $class = "inputtxt other error"; ?>
<p class="error">* <?php echo $othercountry_error; ?></p>
<?php } ?>
</label></p>

<p class="inputother" id="countryother"<?php echo $countryother_display; ?>>
<?php echo $this->Form->text('Account.othercountry', array('required' => false, 'class' => "$class", 'id' => 'othercountry', 'maxlength' => 80, 'placeholder' => 'Please enter your country here')); ?>
</p>
</section>

<section class="mt-2rem">
<h2>Product inquiry (optional)</h2>

<?php if ($products_error) { ?>
<p class="error">* Please select products.</p>
<?php } ?>
<p class="selectp"><span>Select products</span>
<span class="plist<?php if ($products_error) echo ' error'; ?>">
<?php echo $product_checkbox; ?>
</span></p>
<?php if ($contacttype_error) { ?>
<p class="error">* <?php echo $contacttype_error; ?></p>
<?php } ?>
<?php $class = ""; if ($contactdetail_error) { $class = "error"; ?>
<p class="error">* <?php echo $contactdetail_error; ?></p>
<?php } ?>
<p><span>Contact type</span><label class="select"><?php echo $this->Form->select('Account.contacttype', $option_contact, $attributes_contact); ?>
</label></p>
<p class="contactdetail"><?php echo $this->Form->textarea('Account.contactdetail', array('required' => false, 'class' => "$class")); ?></p>
</section>

<section class="confirmterm">
<div>
<p><strong>Please carefully read the following Privacy Policy and Terms of Use before your submission:</strong></p>
<ul>
<li><a href="/policy/" target="_blank">Privacy Policy</a></li>
<li><a href="/terms/" target="_blank">Terms of Use</a></li>
</ul>
<p class="agreebox"><span><label for="agree" class="checkbox"><input type="checkbox" id="agree" class="checkbox" value="agree">I understand and agree to the Privacy Policy and Terms of Use.</label></span></p>
</div>
</section>

<section class="btn mt-2rem">
<input type="button" onclick="location.href='/account/create/'" id="back2" class="btn" value="Back">
<span class="arrowbtn2"><input type="submit" name="confirm" id="confirm" class="btn disabled" value="Confirm" disabled></span>
</section>

</form>
</article>



<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
</body>
</html>