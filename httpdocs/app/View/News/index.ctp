<!DOCTYPE html>
<html lang="en">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/head.php'); ?>

<title>News | NAGASE Personal Care</title>
<meta name="description" itemprop="description" content="News from NAGASE Personal Care, a beauty and personal care ingredients supplier from Japan.">
<meta name="keywords" content="NAGASE Personal Care, News, Topics, Information">

<!-- unique // -->
<link rel="stylesheet" href="/common/news/css/style.css">
<!-- // unique -->
</head>

<body class="fade">
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/analytics.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/header.php'); ?>



<h2 class="content"><span>News</span></h2>
<!-- breadcrumb // -->
<div class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList"><div>
<a itemprop="url" href="/"><span itemprop="name">Home</span></a>
<span itemprop="name">News</span>
</div></div>
<!-- // breadcrumb -->



<!-- 2017 // -->
<article class="content">
<section class="fade mb-0">
<h3>2017</h3>
</section>

<?php
//
//[$xmlstr]...Set xml path.
//

$xmlstr = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/common/news/list_2017.xml');
$newslist = new SimpleXMLElement($xmlstr);

foreach ($newslist->item as $item) {
echo '<section class="fade"><dl itemscope itemtype="https://schema.org/NewsArticle">';
echo '<dd itemprop="dateline"><time datetime="'.$item->date["datetime"].'">'.$item->date.'</time><dd>';
echo '<dt><a href="'.$item->link.'" itemprop="url"><span itemprop="name">'.$item->title.'</span></a></dt>';
echo '<dd itemprop="articleSection">'.$item->description.'</dd>';
echo '</dl></section>';
}
?>

</article>
<!-- // 2017 -->





<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/common/include/cookie.php'); ?>
</body>
</html>