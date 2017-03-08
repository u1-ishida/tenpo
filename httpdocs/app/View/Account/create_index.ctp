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
<li class="current"><span>Introduction</span></li><!--
--><li><span>Input</span></li><!--
--><li><span>Confirm</span></li><!--
--><li><span>Complete</span></li>
</ol>
</div>



<h2 class="content"><span>Registration</span></h2>



<article class="content account">
<section class="reghead fade">
<h3>Introduction</h3>
</section>

<section class="regintro fade">
<p class="mb-1rem">The NAGASE Personal Care website provides product information for scientists, researchers, formulators and marketers in the personal care industry to support their research, formulation, product development, and business expansion.<br>
The website welcomes users to register in order to be updated with NAGASE Personal Care products and additional information. There are cases where we may decline the account request due to the following reasons:</p>
<p class="ml-1rem mb-0">1) The information is false or incomplete.</p>
<p class="ml-1rem mb-1rem">2) The organization is not in the personal care industry or in a similar business to ours.</p>
<p>We appreciate your understanding.</p>
<p>Before registering with NAGASE Personal Care, please read our Privacy Policy and Terms of Use.<br>
Thank you for your interest.</p>
</section>

<section class="regsect fade"><div>
<h4>Privacy Policy</h4>
<p>We are committed to protecting your privacy and providing a safe online and digital experience for all users. Because we gather certain types of information about and from users so that we can better serve your needs, you should fully understand the terms and conditions surrounding the collection and use of this information. This Privacy Policy discloses what information we gather, how we use it, how to correct or change it, and what steps we take to safeguard personal information provided to us both online and offline.</p>
<p class="right mb-0"><a href="/policy/" class="btn" target="_blank">View more...</a></p>
</div></section>

<section class="regsect fade"><div>
<h4>Terms of Use</h4>
<p>Please carefully read these Terms of Use before using this NAGASE Personal Care website: https://www.nagase-personalcare.com (this &ldquo;website&rdquo;). Your access to, and use of, this website and its content may be revoked or limited by us at any time without providing a reason and is further conditioned upon your acceptance and compliance in full with these Terms of Use. If you do not accept these terms, you must leave this website immediately and cease any further use of any materials you have obtained therefrom.</p>
<p class="right mb-0"><a href="/terms/" target="_blank">View more...</a></p>
</div></section>

<form action="/account/create/input" method="POST">
<section class="btn mt-2rem" id="account">
<input type="button" onclick="location.href='/login/'" id="cancel" class="btn" value="Cancel">
<span class="arrowbtn3"><input type="submit" id="reginput" class="btn" value="Create new account"></span>
</section>
</form>
</article>



<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
</body>
</html>