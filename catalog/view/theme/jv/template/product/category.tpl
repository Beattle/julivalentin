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
<div id="content" class="category-products"><?php echo $content_top; ?>
  <div class="left-column">
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($categories) { ?>
  <div class="category-list">
    <?php if (count($categories) <= 5) { ?>
    <ul>
      <?php foreach ($categories as $category) { ?>
      <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
      <?php } ?>
    </ul>
    <?php } else { ?>
    <?php for ($i = 0; $i < count($categories);) { ?>
    <ul>
      <?php $j = $i + ceil(count($categories) / 4); ?>
      <?php for (; $i < $j; $i++) { ?>
      <?php if (isset($categories[$i])) { ?>
      <li><a href="<?php echo $categories[$i]['href']; ?>"><?php echo $categories[$i]['name']; ?></a></li>
      <?php } ?>
      <?php } ?>
    </ul>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if ($products) { ?>
  <div class="product-list">
    <?php foreach ($products as $product) { ?>
    <div class="product <?php echo $product['product_id']; ?>">
      <?php if ($product['thumb']) { ?>
      <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a>
          <button title="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="buy"></button>
      </div>
      <?php } ?>
      <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
      <!--<div class="description"><?php /*echo $product['description']; */?></div>-->
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
    </div>
    <?php } ?>
  </div>
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } ?>
  <?php if (!$categories && !$products) { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php } ?>
  <?php echo $content_bottom; ?>
  </div>
    <div class="right-column">
        <div id="column-right">
            <article id="article">
                <?php if ($thumb || $description) { ?>
                    <div class="category-info">
                        <?php if ($thumb) { ?>
                            <div class="image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
                        <?php } ?>
                        <?php if ($description) { ?>
                            <?php echo $description; ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </article>
        </div>
    </div>
</div>

<?php echo $footer; ?>