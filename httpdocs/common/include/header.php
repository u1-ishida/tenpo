<?php
$back_url = $_SERVER['REQUEST_URI'];
if ($id) { ?>
<header id="top" class="fade"><div class="wrap clearfix">
<span class="menutoggle"><img src="/common/img/sp_menu_open.png" alt="menu"></span>
<h1><a href="/"><img src="/common/img/logo_head.png" alt="NAGASE Personal Care" title="NAGASE Personal Care"></a></h1>

<div class="utility loggedin">
<div class="loginBtn logoutBtn">
<span class="accountName">
<a href="/account/" class="loginname"><?php echo "$FirstName $LastName" ?></a>
</span>
<a href="/account/logout" class="logout">Logout</a>
</div>

<nav>
<ul itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
<li itemprop="name"><a itemprop="url" href="/about/">About Us</a></li>
<li itemprop="name"><a itemprop="url" href="/product/index">Products</a></li>
<li itemprop="name"><a itemprop="url" href="/contact/input">Contact Us</a></li>
</ul>
</nav>

<div class="seachBox clearfix">
<script>
  (function() {
    var cx = '000596079448607557792:r0mrr054qii';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:searchbox-only></gcse:searchbox-only>
</div>

</div>
</header>
<?php } else { ?>
<header id="top" class="fade"><div class="wrap clearfix">
<span class="menutoggle"><img src="/common/img/sp_menu_open.png" alt="menu"></span>
<h1><a href="/"><img src="/common/img/logo_head.png" alt="NAGASE Personal Care" title="NAGASE Personal Care"></a></h1>

<div class="utility">
<nav>
<ul itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
<li itemprop="name"><a itemprop="url" href="/about/">About Us</a></li>
<li itemprop="name"><a itemprop="url" href="/product/">Products</a></li>
<li itemprop="name"><a itemprop="url" href="/contact/input.html">Contact Us</a></li>
</ul>
</nav>

<div class="loginBtn">
<form action="/login/" method="POST">
<span class="headbtn"><input type="submit" id="login" class="btn" value="Log in"></span>
</form>
</div>

<div class="seachBox clearfix">
<script>
  (function() {
    var cx = '000596079448607557792:r0mrr054qii';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:searchbox-only></gcse:searchbox-only>
</div>

</div>

</div>
</header>
<?php } ?>
