<!DOCTYPE html>
<html lang="en">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/head.php'); ?>

<title><?php echo $product['ProductName']; ?> | Products | NAGASE Personal Care</title>
<meta name="keywords" content="NAGASE, Pesonal Care, Products, <?php echo $product['ProductName']; ?>">

<!-- unique // -->
<link rel="stylesheet" href="/common/product/css/style.css">
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



<h2 class="content"><span><?php echo $product['ProductName']; ?></span></h2>
<!-- breadcrumb // -->
<div class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList"><div>
<a itemprop="url" href="/"><span itemprop="name">Home</span></a>
<a itemprop="url" href="/product/"><span itemprop="name">Products</span></a>
<span itemprop="name"><?php echo $product['ProductName']; ?></span>
</div></div>
<!-- // breadcrumb -->



<article class="content">

<section class="p_name fade mb-2rem">
<h3><?php echo $product['ProductName']; ?></h3>
</section>

<section class="p_spec clearfix fade">
<img src="/files/product_img/<?php echo $product['tenpoProductId']; ?>/product_image.jpg">

<dl>
<dt>INCI Name</dt>
<dd><?php echo $product['INCIName']; ?></dd>
</dl>

<?php if ($product['Function']) { ?>
<dl>
<dt>Function</dt>
<?php foreach($product['Function'] as $function) { ?>
<dd><span><?php echo $function; ?></span></dd>
<?php } ?>
</dl>
<?php } ?>

<?php if ($product['Benefit']) { ?>
<dl>
<dt>Benefit</dt>
<dd>
<?php foreach($product['Benefit'] as $benefit) { ?>
<span><?php echo $benefit; ?></span>
<?php } ?>
</dd>
</dl>
<?php } ?>

<?php if (count($product['Ceretification']) > 0) { ?>
<dl>
<dt>Certification</dt>
<dd>
<?php foreach($product['Ceretification'] as $certification) { ?>
<span><?php echo $certification; ?></span><?php } ?>
</dd>
</dl>
<?php } ?>

<?php if ($product['Application']) { ?>
<dl>
<dt>Application</dt>
<dd>
<?php foreach($product['Application'] as $application) { ?>
<span id="<?php echo str_replace(" ", "", $application); ?>"><?php echo $application; ?></span><?php } ?>
</dd>
</dl>
<?php } ?>

</section>

<section class="p_detail fade">
<h4>Product Description</h4>
<p><?php echo nl2br($product['ProductDescription']); ?></p>
</section>

<?php if (count($document_list) > 0) { ?>
<section class="p_docs fade">
<h4>Documents</h4>
<?php if ($id) { ?>
<ul class="download">
<?php foreach($document_list as $document) { ?>
<li><a href="<?php echo $document['url']."?UID=".$id ?>" rel="nofollow" target="_blank"><?php echo $document['file_name'] ?></a></li>
<?php } ?>
</ul>

<?php } else { ?>
<!-- before login // --> 
<p class="beforelogin">Please <a href="/login/?back=<?php echo $back_url; ?>">log in</a> or <a href="/account/create/">create new account</a> to download catalogs and contact to NAGASE Personal Care.</p>
<!-- // before login -->
<ul class="download">
<?php foreach($document_list as $document) { ?>
<li class="deactive"><?php echo $document['file_name'] ?></li>
<?php } ?>
</ul>
<?php } ?>
</section>
<?php } ?>

<?php if (count($studies_list) > 1) { ?>
<section class="p_detail fade">
<h4>Available Studies</h4>
<p class="notice">* Please contact for further information.</p>
<p class="shead">
<?php foreach($studies_list as $studies) { ?>
<?php echo $studies; ?><br>
<?php } ?>
</p>
</section>
<?php } ?>

<?php if ($product['AvailableRegion']) { ?>
<section class="p_detail fade">
<h4>Available Region</h4>
<p class="shead"><?php echo $product['AvailableRegion']; ?></p>
</section>
<?php } ?>

<section class="p_docs fade">
<!-- disclaimer // -->
<p class="disclaimer_trigger"><a class="disclaimer_trigger" href="#disclaimer" data-remodal-target="disclaimer">Disclaimer</a></p>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/disclaimer.php'); ?>
<!-- // disclaimer -->

<?php if ($id) { ?>
<a href="/contact/input/<?php echo $product['tenpoProductId']; ?>" class="btn">Contact Us</a>
<?php } else { ?>
<span class="btn">Contact Us</span>
<?php } ?>
</section>

</article>



<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/product_lineup.php'); ?>




<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
<script src="/common/js/productlist.js"></script>
</body>
</html>
