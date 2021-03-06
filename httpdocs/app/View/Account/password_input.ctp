<!DOCTYPE html>
<html lang="en">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/head.php'); ?>

<title>Password change | NAGASE Personal Care</title>

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
--><li><span>Complete</span></li>
</ol>
</div>



<article class="content account">
<form action="/account/password/complete" method="POST">

<section>
<h2>Password change</h2>
</section>

<section>
<!--
<p class="error">* Passwords do not match.</p>
<p class="error">* Password must be 8 characters or more.</p>
<p class="error">* Please enter Password.</p>
-->
<?php $class = "inputtxt"; if ($password_error) { $class = "inputtxt error"; ?>
<p class="error">* <?php echo $password_error; ?>.</p>
<?php } ?>
<p><span>New PASSWORD</span><input id="password" type="password" name="password" class="<?php echo $class; ?>"></p>
<p class="notice">* Minimum of 8 characters</p>
<!--
<p class="error">* Passwords do not match.</p>
<p class="error">* Password must be 8 characters or more.</p>
<p class="error">* Please re-enter Password.</p>
-->
<?php $class = "inputtxt"; if ($password2_error) { $class = "inputtxt error"; ?>
<p class="error">* <?php echo $password2_error; ?>.</p>
<?php } ?>
<p><span>Re-enter PASSWORD</span><input id="password2" type="password" name="password2" class="<?php echo $class; ?>"></p>
</section>

<section class="btn mt-2rem" id="pwchange">
<input type="button" onclick="location.href='/account/'" id="cancel2" class="btn" value="Cancel">
<span class="arrowbtn3"><input type="submit" name="complete" id="compform" class="btn" value="Submit"></span>
</section>

</form>
</article>

<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
</body>
</html>