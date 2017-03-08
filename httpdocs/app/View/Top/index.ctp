<!DOCTYPE html>
<html lang="en">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/head.php'); ?>

<title>NAGASE Personal Care</title>
<meta name="description" itemprop="description" content="NAGASE Personal Care - Your Beauty &amp; Personal Care Ingredients Supplier. NAGASE Personal Care offers innovative and sustainable solutions for your needs. We continue to expand our network across the globe, building a better world together. With the highest standards of integrity for more than 180 years, We continue to build relationships with trusted partners to increase prosperity.">
<meta name="keywords" content="NAGASE, Beauty, Pesonal Care, cosmetic ingredients, household products ingredients, supplier, distributor, manufacturer, Japan">

<!-- unique // -->
<link rel="stylesheet" href="/css/style.css"/>
<link rel="stylesheet" href="/css/slick.css"/>
<link rel="stylesheet" href="/css/slick-theme.css"/>
<!-- // unique -->

<?php echo $change_tab; ?>
<script>
function select_category() {

	var function_list = [
<?php echo $function_list; ?>
	];

	var benefit_list = [
<?php echo $benefit_list; ?>
	];

	var application_list = [
<?php echo $application_list; ?>
	];

	cat01 = document.category.cat01;
	index = cat01.selectedIndex;
	val = cat01.value;
	cat02 = document.category.cat02;
	//要素を全て削除
	while(cat02.lastChild) {
		cat02.removeChild(cat02.lastChild);
	}
	if (val == "function") {
		for (var i = 0; i < function_list.length; i++) {
			option = document.createElement('option');
    		option.setAttribute('value', function_list[i]);
    		option.innerHTML = function_list[i];
			cat02.appendChild(option);
		}
	} else if (val == "benefit") {
		for (var i = 0; i < benefit_list.length; i++) {
			option = document.createElement('option');
    		option.setAttribute('value', benefit_list[i]);
    		option.innerHTML = benefit_list[i];
			cat02.appendChild(option);
		}
	} else if (val == "application") {
		for (var i = 0; i < application_list.length; i++) {
			option = document.createElement('option');
    		option.setAttribute('value', application_list[i]);
    		option.innerHTML = application_list[i];
			cat02.appendChild(option);
		}
	}
}
</script>

</head>

<body class="fade">
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/analytics.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/header.php'); ?>



<div class="key-visual">
<div id="key01"><img src="/img/kv1.jpg"><p><span>NAGASE Personal Care</span>Your Beauty &amp; Personal Care Ingredients Supplier</p></div>
<div id="key02"><img src="/img/kv2.jpg"><p><span>Moving forward together</span>NAGASE Personal Care offers innovative and sustainable solutions for your needs</p></div>
<div id="key03"><img src="/img/kv3.jpg"><p></p></div>
<div id="key04"><img src="/img/kv4.jpg"><p>We continue to expand our network across the globe,<br>building a better world together</p></div>
<div id="key05"><img src="/img/kv5.jpg"><p>With the highest standards of integrity for more than 180 years,<br>We continue to build relationships with trusted partners to increase prosperity</p></div>
</div>



<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/product_lineup.php'); ?>



<article class="news fade">
<h2>News</h2>

<?php
//
//[$xmlstr]...Set xml path.
//[$cnt]...Set the number of display items.
//

$xmlstr = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/common/news/list_2017.xml');
$newslist = new SimpleXMLElement($xmlstr);
$i = 0;
$cnt = 3;
foreach ($newslist->item as $item) {
if($i >= $cnt){
break;
}else{
echo '<dl class="clearfix" itemscope itemtype="https://schema.org/NewsArticle">';
echo '<dd itemprop="dateline"><time datetime="'.$item->date["datetime"].'">'.$item->date.'</time><dd>';
echo '<dt><a href="'.$item->link.'" itemprop="url"><span itemprop="name">'.$item->title.'</span></a></dt>';
echo '</dl>';
$i++;
}}
?>

<p class="right mt-1rem"><a href="/news/">View more...</a></p>
</article>



<article class="about fade clearfix">
<section>
<h2>NAGASE Personal Care</h2>
<p>NAGASE Personal Care, a division of NAGASE &amp; CO., LTD., is an established supplier of beauty and personal care ingredients from Japan. We provide a wide range of specialty, basic and naturally derived ingredients to researchers, formulators, and marketers in the Personal Care industry.<br>
<span class="indent">&nbsp;&nbsp;&nbsp;&nbsp;</span>With over 180 years of experience as the NAGASE Group, NAGASE Personal Care has built strong working relationships with our customers and will continue to expand our network across the globe. We leverage the strengths of our group companies in manufacturing and logistics to become an international service provider, delivering excellent products and services that suit your needs.<br>
<span class="indent">&nbsp;&nbsp;&nbsp;&nbsp;</span>NAGASE Personal Care's mission is to become a respected global service brand, developed from our long history and experience. We aim to provide high-value products and effective services to both our international and domestic customers.</p>
<p class="more"><a href="/about/">View more</a></p>
</section>
<section>
<img src="/img/about_img01.jpg">
</section>
</article>





<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>

<script src="/js/slick.min.js"></script>
<script src="/js/script.js"></script>
<script src="/common/js/productlist.js"></script>
</body>
</html>