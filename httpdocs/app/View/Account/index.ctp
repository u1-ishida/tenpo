<!DOCTYPE html>
<html lang="en">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/head.php'); ?>

<title>Account information | NAGASE Personal Care</title>
<meta name="description" itemprop="description" content="NAGASE Personal Care, Who we are, What we do">
<meta name="keywords" content="NAGASE, Pesonal Care, cosmetic ingredients, household ingredients, trading company, distributor, manufacturor, Japan">

<!-- unique // -->
<link rel="stylesheet" href="/common/account/css/style.css">
<!-- // unique -->
<script>
$(function(){
$('section#change input.btn').click(function(){
window.location.href = "/account/edit/input";
});
$('section#dopwchange input.btn').click(function(){
window.location.href = "/account/password/input";
});
});
</script>
</head>

<body class="fade">
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/analytics.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/header.php'); ?>



<h2 class="content mb-0"><span>Account information</span></h2>
<!-- breadcrumb // -->
<div class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList"><div>
<a itemprop="url" href="/"><span itemprop="name">Home</span></a>
<span itemprop="name">Account information</span>
</div></div>
<!-- // breadcrumb -->



<article class="content">

<section class="fade clearfix">
<h3>Account information change</h3>
<p>To change your registered information, please click below:</p>
<section class="btn mt-2rem" id="change">
<span class="arrowbtn"><input id="compform" class="btn center" value="Account information change"></span>
</section>
</section>



<section class="fade clearfix">
<h3>Password change</h3>
<p>To change the password, please click below:</p>
<section class="btn mt-2rem" id="dopwchange">
<span class="arrowbtn"><input id="compform" class="btn center" value="Password change"></span>
</section>
</section>


</article>




<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
</body>
</html>