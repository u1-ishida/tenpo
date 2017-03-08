<?php
$back_url = $_SERVER['REQUEST_URI'];
if ($id) { ?>
<header id="top" class="fade"><div>
<span class="menutoggle"><img src="/common/img/sp_menu_open.png" alt="menu"></span>
<h1><a href="/"><img src="/common/img/logo_head.png" alt="NAGASE Personal Care" title="NAGASE Personal Care"></a></h1>

<section class="loggedin">
<a href="/account/" class="loginname"><?php echo "$FirstName $LastName" ?></a>
<span>|</span>
<a href="/account/logout" class="logout">Logout</a>
</section>

<nav>
<ul itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
<li itemprop="name"><a itemprop="url" href="/about/">About Us</a></li>
<li itemprop="name"><a itemprop="url" href="/product/index">Products</a></li>
<li itemprop="name"><a itemprop="url" href="/contact/input">Contact Us</a></li>
</ul>
</nav>
</div>
</header>
<?php } else { ?>
<header id="top" class="fade"><div>
<span class="menutoggle"><img src="/common/img/sp_menu_open.png" alt="menu"></span>
<h1><a href="/"><img src="/common/img/logo_head.png" alt="NAGASE Personal Care" title="NAGASE Personal Care"></a></h1>

<section>
<form action="/login/login" method="POST">
<input type="hidden" name="back" value="<?php echo $back_url; ?>">
<span>Email</span><input id="id" type="text" name="id">
<span>Password</span><input id="password" type="password" name="password">
<span class="headbtn"><input type="submit" id="login" class="btn" value="Log in"></span>
<span class="headbtn"><input type="button" id="registration" class="btn" value="Registration"></span>
</form>
</section>

<nav>
<ul itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
<li itemprop="name"><a itemprop="url" href="/about/">About Us</a></li>
<li itemprop="name"><a itemprop="url" href="/product/index">Products</a></li>
<li itemprop="name"><a itemprop="url" href="/contact/input">Contact Us</a></li>
</ul>
</nav>
</div>
</header>
<?php } ?>
