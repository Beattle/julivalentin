<?php $i = 1;
$c = $i - $lead_art_amount;
foreach ($articles as $article) { ?>
    <div class="ac_column <?php if ($columns <= 1 || $i <= $lead_art_amount) echo 'c1 ';
    if ($c % $columns == 0 && $i != 1) echo $class_last; ?>"
         style="width:<?php if ($i > $lead_art_amount) echo $width; else echo 100 . '%'; ?>;">
        <?php foreach ($sort as $item) { ?>
            <?php if ($item == 'title' && $title_order !== 0) { ?>
                <?php if ($title_as_link) { ?>
                    <h4 class="ac_title" style="text-align:<?php echo $title_order; ?>"><a
                            href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a></h4>
                <?php } else { ?>
                    <h4 class="ac_title"
                        style="text-align:<?php echo $title_order; ?>"><?php echo $article['title']; ?></h4>
                <?php } ?>
            <?php } ?>
            <?php if (($item == 'info' && $info_order !== 0) && (!$disable_author || !$disable_create_date || !$disable_mod_date || !$disable_author || (!$disable_com_count && $article['allow_comments'] == 1))) { ?>
                <div class="ac_info" style="text-align:<?php echo $info_order; ?>">
                    <?php if (!$disable_author) { ?><span
                        class="info"><?php echo $text_author . $article['username']; ?></span><?php } ?>
                    <?php if (!$disable_create_date) { ?><span
                        class="info"><?php echo $text_created . $article['date_added']; ?></span><?php } ?>
                    <?php if (!$disable_mod_date) { ?><span
                        class="info"><?php echo $text_modified . $article['date_modified']; ?></span><?php } ?>
                    <?php if (!$disable_com_count && $article['allow_comments'] == 1 && $article['comment_access']) { ?><?php if ($comment_engine == 2) { ?>
                        <a class="info"
                           href="<?php echo $article['href']; ?>#disqus_thread"></a><?php } elseif ($comment_engine == 0) { ?>
                        <a href="<?php echo $article['href'] . '#comments'; ?>"
                           class="info"><?php echo $text_comments . $article['comments']; ?></a><?php }
                    } ?>&nbsp;
                </div>
            <?php } ?>
            <?php if ($item == 'image' && !empty($article['thumb']) && $image_order !== 0) { ?>
                <div class="ac_image" style="<?php echo $image_order; ?>">
                    <?php if ($image_as_link) { ?>
                        <a href="<?php echo $article['href']; ?>"><img style="margin:<?php echo $image_margin; ?>;"
                                                                       alt="<?php echo $article['title']; ?>"
                                                                       src="<?php echo $article['thumb']; ?>"/></a>
                    <?php } else { ?>
                        <img style="margin:<?php echo $image_margin; ?>;" alt="<?php echo $article['title']; ?>"
                             src="<?php echo $article['thumb']; ?>"/>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($item == 'text' && $text_order !== 0) { ?>
                <div class="ac_text" style="text-align:<?php echo $text_order; ?>">
                    <?php if ($text_as_link) { ?>
                        <a href="<?php echo $article['href']; ?>"><?php echo $article['intro']; ?></a>
                    <?php } else { ?>
                        <?php echo $article['intro']; ?>
                    <?php } ?>
                    <div class="article-set-category">
                        <?php if ($article['categories'] && !$disable_cat_list) { ?>
                            <span><?php echo $text_category; ?></span>
                            <?php $c_i = 1;
                            foreach ($article['categories'] as $category) { ?>
                                <?php if ($article['c_count'] == $c_i || $article['c_count'] == 0) { ?>
                                    <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                                <?php } else { ?>
                                    <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>,
                                <?php } ?>
                                <?php $c_i++;
                            } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <?php if ($item == 'r_more' && $readmore_order !== 0) { ?>
                <div class="ac_readmore" style="text-align:<?php echo $readmore_order; ?>">
                    <a class="button" href="<?php echo $article['href']; ?>"><span><?php echo $text_readmore; ?></span></a>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <?php if ($i != 1 && $c % $columns == 0 && $columns > 1) echo '<div class="clr"></div>'; ?>
    <?php $i++;
    $c++;
} ?>