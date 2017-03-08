<!DOCTYPE html>
<html lang="en">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/head.php'); ?>

<title>User account | NAGASE Personal Care</title>

<!-- unique // -->
<link rel="stylesheet" href="/common/login/css/style.css">
<meta name="robots" content="noindex,nofollow">
<!-- // unique -->
</head>

<body class="fade">
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/analytics.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/header_form.php'); ?>



<h2 class="content"><span>User account</span></h2>
<!-- breadcrumb // -->
<div class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList"><div>
<a itemprop="url" href="/"><span itemprop="name">Home</span></a>
<span itemprop="name">User account</span>
</div></div>
<!-- // breadcrumb -->


<div class="container">

<section class="fade">
<p class="intro">For those with a NAGASE Personal Care account, please log in to download catalogs, request test results, and send inquiries.<br>
If you haven't already registered at NAGASE Personal Care, please create a new account to access NAGASE Personal Care.</p>
</section>

<article class="content lc">
<section class="login fade">
<h3>Log in</h3>
<form action="/login/login" method="POST">
<input type="hidden" name="back" value="<?php echo $back; ?>">
<?php $class = ""; if ($login_error) { $class = "error"; ?>
<p class="error">* Input content is incorrect. Please confirm.</p>
<?php } ?>
<p><span class="head">Email</span><input name="id" id="id" type="text" class="<?php echo $class; ?>"></p>
<p><span class="head">Password</span><input name="password" id="password" type="password" class="<?php echo $class; ?>"></p>
<p class="forgotpw"><a href="/password_reset/order/input">Reset password</a></p>
<p><label for="rememberme" class="checkbox"><input type="checkbox" id="rememberme" class="checkbox">Remember me</label></p>
<p class="center" id="create"><span class="arrowbtn4"><input type="submit" id="login" class="btn" value="Log in"></span></p>
</form>
</section>
</article>



<article class="content rc">
<section class="mb-0 fade">
<h3>Create new account</h3>
<p class="center"><span class="arrowbtn4"><a class="btn" href="/account/create/" id="registration">Go to Registration</a></span></p>
</section>
</article>

</div>


<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
</body>
</html>
