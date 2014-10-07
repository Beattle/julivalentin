<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div class="breadcrumb">
    <?php $last = array_search(end($breadcrumbs), $breadcrumbs); ?>
    <?php foreach ($breadcrumbs as $key => $breadcrumb) { ?>
    <?php if($last !== $key): ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php else: ?>
    <?php echo $breadcrumb['separator']; ?><span class="last-bread"><?php echo $breadcrumb['text']; ?></span>
    <?php endif; ?>
    <?php } ?>
</div>
<div id="content" class="category search_category"><?php echo $content_top; ?>

    <h1><?php echo $heading_title; ?></h1>
    <h2><?php echo $text_search; ?></h2>
    <div class="search-results mCustomScrollbar">
        <?php if ($products) { ?>
        <div class="product-list">

            <?php foreach ($products as $product) { ?>
            <div class="product">
                <?php if ($product['thumb']) { ?>
                <div class="image">
                    <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a>
                    <input class="buy" type="button" title="Купить" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" />
                </div>
                <?php } ?>

                <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>

                <div class="description"><?php echo $product['description']; ?></div>

                <?php if ($product['price']) { ?>
                <div class="price">
                    <?php if (!$product['special']) { ?>
                    <?php echo $product['price']; ?>
                    <?php } else { ?>
                    <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
                    <?php } ?>
                    <span class="weight">(<?php echo $product['weight']; ?>)</span>
                </div>
                <?php } ?>
                <?php if ($product['rating']) { ?>
                <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
                <?php } ?>
            </div>
            <?php } ?>

        </div>
    </div>
    <div class="pagination"><?php echo $pagination; ?></div>
    <?php
		//echo '<pre>'; print_r($products); echo '</pre>';

		} else { ?>
    <div class="content"><?php echo $text_empty; ?></div>
    <?php }?>
    <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>