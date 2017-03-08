<!DOCTYPE html>
<html lang="en">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/head.php'); ?>

<title>Products | NAGASE Personal Care</title>
<meta name="description" itemprop="description" content="Product List of NAGASE Personal Care website, a beauty and personal care ingredients supplier from Japan.">
<meta name="keywords" content="NAGASE, Pesonal Care, Products">

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

<body>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/analytics.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/header.php'); ?>



<h2 class="content"><span>Products</span></h2>
<!-- breadcrumb // -->
<div class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList"><div>
<a itemprop="url" href="/"><span itemprop="name">Home</span></a>
<span itemprop="name">Products</span>
</div></div>
<!-- // breadcrumb -->



<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/product_lineup.php'); ?>




<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<script src="/common/js/productlist.js"></script>
</body>
</html>