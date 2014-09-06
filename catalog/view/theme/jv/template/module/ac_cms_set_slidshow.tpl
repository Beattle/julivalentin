<div class="article-slideshow ss_<?php echo $module; ?>">
    <div class="slideshow">
        <div id="slideshow_as<?php echo $module; ?>" class="nivoSlider"
             style="width: <?php echo $slideshow_width; ?>px; height: <?php echo $slideshow_height; ?>px;">
            <?php $c = 1;
            foreach ($articles as $article) { ?>
                <?php if (!empty($article['thumb'])) { ?>
                    <?php if ($image_as_link) { ?>
                        <a href="<?php echo $article['href']; ?>"><img alt="<?php echo $article['title']; ?>"
                                                                       style="margin:<?php echo $image_margin; ?>;"
                                                                       title="#htmlcaption_as<?php echo $c . '_' . $module; ?>"
                                                                       src="<?php echo $article['thumb']; ?>"/></a>
                    <?php } else { ?>
                        <img alt="<?php echo $article['title']; ?>" style="margin:<?php echo $image_margin; ?>;"
                             title="#htmlcaption_as<?php echo $c . '_' . $module; ?>"
                             src="<?php echo $article['thumb']; ?>"/>
                    <?php } ?>
                <?php } else { ?>
                    <img alt="<?php echo $article['title']; ?>" title="#htmlcaption_as<?php echo $c . '_' . $module; ?>"
                         src="<?php echo (defined('HTTP_IMAGE')) ? HTTP_IMAGE . 'data/transparent_sd.gif' : HTTP_SERVER . 'image/data/transparent_sd.gif'; ?>"/>
                <?php } ?>
                <?php $c++;
            } ?>
        </div>
    </div>
    <?php $i = 1;
    foreach ($articles as $article) { ?>
        <div id="htmlcaption_as<?php echo $i . '_' . $module; ?>" class="nivo-html-caption">
            <?php if ($title_order !== 0) { ?>
                <div class="caption-headings">
                    <?php if ($title_as_link) { ?>
                        <h4 class="ac_title" style="text-align:<?php echo $title_order; ?>"><a
                                href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a></h4>
                    <?php } else { ?>
                        <h4 class="ac_title"
                            style="text-align:<?php echo $title_order; ?>"><?php echo $article['title']; ?></h4>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($text_order !== 0) { ?>
                <div class="caption-content" style="text-align:<?php echo $text_order; ?>">
                    <?php if ($text_as_link) { ?>
                        <a href="<?php echo $article['href']; ?>"><?php echo $article['intro']; ?></a>
                    <?php } else { ?>
                        <?php echo $article['intro']; ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <?php $i++;
    } ?>
</div>

<script type="text/javascript"><!--
    $(document).ready(function () {
        $('#slideshow_as<?php echo $module; ?>').nivoSlider();
        $('.ss_<?php echo $module; ?> .nivo-caption').css('width', '<?php echo $caption_width . 'px'; ?>');
        $('.ss_<?php echo $module; ?> .nivo-caption').css('margin-top', '<?php echo $slideshow_cm . 'px'; ?>');
        $('.ss_<?php echo $module; ?> .nivo-caption').css('left', '<?php echo $left_push . 'px'; ?>');
    });
    --></script>