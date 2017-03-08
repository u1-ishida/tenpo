<article class="plist fade">
<h2><span>Product Lineup</span></h2>

<div class="search">
<p class="tabs">
<a href="#keyword" onclick="ChangeTab('keyword');return false;" id="keyword" class="tab current" title="Search from the input words.">Keyword Search</a>
<a href="#filter" onclick="ChangeTab('selection');return false;" id="selection" class="tab" title="Search from the selected item.">Filter Selection</a>
</p>

<div id="keyword" class="tabcontent current">
<form action="/product/search" method="POST">
<input type="text" class="inputword" name="keywordsearch" value="<?php echo $keywordsearch; ?>">
<input type="submit" class="searchbtn" name="keywordsearchbtn" value="Search" title="Display searched items with the input words.">
</form>
</div>
<div id="selection" class="tabcontent">
<form name="category" action="/product/search" method="POST">
<label>
<?php echo $cat01_select; ?>
</label>
<label>
<?php echo $cat02_select; ?>
</label>

<input type="submit" class="searchbtn" name="categorysearchbtn" value="Search" title="Display searched items with the selected item.">
</form>
</div>
</div>

<section class="productlist fade clearfix">

<?php foreach($product_list as $product) { ?>
<dl class="product">
<dd id="productimg"><a href="/product/<?php echo $product['tenpoProductId']; ?>"><?php echo $product['imgsrc']; ?></a></dd>
<dt id="productname"><?php echo $product['ProductName']; ?></dt>
<?php foreach($product['Function'] as $function) { ?>
<dd id="productfunc"><?php echo $function; ?></dd>
<?php } ?>
<dd id="productapps">
<?php foreach($product['Application'] as $application) { ?>
<img src="/common/product/img/ico_<?php echo str_replace(" ", "",$application); ?>.png" alt="<?php echo $application; ?>">
<?php } ?>
</dd>
</dl>
<?php } ?>

</section>
</article>
