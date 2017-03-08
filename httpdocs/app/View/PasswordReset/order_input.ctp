<!DOCTYPE html>
<html lang="en">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/head.php'); ?>

<title>Reset password | NAGASE Personal Care</title>

<!-- unique // -->
<link rel="stylesheet" href="/common/login/css/style.css">
<meta name="robots" content="noindex,nofollow">
<!-- // unique -->
</head>

<body class="fade">
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/analytics.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/header.php'); ?>



<h2 class="content"><span>Reset password</span></h2>
<!-- breadcrumb // -->
<div class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList"><div>
<a itemprop="url" href="/"><span itemprop="name">Home</span></a>
<a itemprop="url" href="/login/"><span itemprop="name">Log in</span></a>
<span itemprop="name">Reset password</span>
</div></div>
<!-- // breadcrumb -->



<article class="content">
<section class="fade mb-2rem">
<p class="resettxt">Enter the email address associated with your account, and we will send you instructions on how to reset your password.</p>
</section>
<section class="login fade">
<form class="pwreset" action="/password_reset/order/complete" method="POST">
<?php $class = "inputtxt"; if ($email_error) { $class = "inputtxt error"; ?>
<p class="error">* <?php echo $email_error; ?></p>
<?php } ?>
<p><span class="head">Email</span><!--
--><?php echo $this->Form->text('PasswordReset.email',array('required' => false, 'class' => "$class", 'id' => 'id')); ?>
</p>
<p class="center"><span class="arrowbtn4"><input type="submit" name="confirm" id="login" class="btn  pwreset" value="Submit"></span></p>
</form>
</section>
</article>




<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
</body>
</html>