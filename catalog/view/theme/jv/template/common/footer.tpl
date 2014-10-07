</div>
<footer>
    <?php if ($logo) { ?>
        <div id="logo">
            <a href="<?php echo $home; ?>">
                <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
            </a>
        </div>
    <?php } ?>
    <nav id="menu">
        <ul>
            <?php $lastKey = array_search(end($headermenu), $headermenu); ?>
            <?php foreach($headermenu as $key => $header){?>
            <li class='level-1 <?php if(!empty($header['class'])){ echo $header['class'];} ?>'>
                <a href="<?php echo $header['link'] ?>"><?php echo $header['title']; ?></a>
                <?php if($header['sub_title']){?>
                    <div>
                        <ul>
                            <?php foreach($header['sub_title'] as $subtitle){ ?>
                                <li>
                                    <?php if ($subtitle['link']):?>
                                        <a href="<?php echo $subtitle['link']?>"><?php echo $subtitle['title']; ?></a>
                                    <?php endif;?>
                                    <?php if($subtitle['sub_title']){?>
                                        <ul>
                                            <?php foreach($subtitle['sub_title'] as $subtitle){ ?>
                                                <li>
                                                    <?php if(($subtitle['link'])):?>
                                                        <a href="<?php echo $subtitle['link']?>"><?php echo $subtitle['title']; ?></a>
                                                    <?php endif; ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php }?>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
                <?php }?>
                <?php  echo ($key !==$lastKey) ? '<li class="v-sep">':null ?>
                <?php } ?>
        </ul>
    </nav>
    <div class="help-user-nav">
        <ul class="custommenu>">
            <?php foreach($custommenu as $menu){?>
                <li><a href="<?php echo $menu['link'] ?>"><?php echo $menu['title']; ?></a>
                    <?php if($menu['sub_title']){?>
                        <div>
                            <ul>
                                <?php foreach($menu['sub_title'] as $subtitle){ ?>
                                    <li>
                                        <?php if(isset($subtitle['href'])){?>
                                            <a href="<?php echo $subtitle['href']; ?>"><?php echo $subtitle['title']; ?></a>
                                        <?php }else{?>
                                            <a href="<?php echo $subtitle['link']?>"><?php echo $subtitle['title']; ?></a>
                                        <?php } ?>
                                        <?php if($subtitle['sub_title']){?>

                                            <ul>
                                                <?php foreach($subtitle['sub_title'] as $subtitle){ ?>
                                                    <li>
                                                        <?php if(isset($subtitle['href'])){?>
                                                            <a href="<?php echo $subtitle['href']; ?>"><?php echo $subtitle['title']; ?></a>
                                                        <?php }else{?>
                                                            <a href="<?php echo $subtitle['link']?>"><?php echo $subtitle['title']; ?></a>
                                                        <?php } ?>
                                                    </li>
                                                <?php }?>
                                            </ul>
                                        <?php }?>
                                    </li>
                                <?php }?>
                            </ul>
                        </div>

                    <?php }?>
                </li>
            <?php  }?>

        </ul>
    </div>
    <div id="social-networks">
        <a href="#" id="Facebook" title="Join us on Facebook"><img src="catalog/view/theme/jv/image/facebook.png"/></a>
        <a href="#" id="Instagram" title="See our pics on Instagram"><img src="catalog/view/theme/jv/image/instagram.png"/></a>
        <a href="#" id="Pinterest" title="Pinterest"><img src="catalog/view/theme/jv/image/pinterest.png"></a>
        <a href="#" id="Vkontakte" title="Join us on Vkontakte"><img src="catalog/view/theme/jv/image/vk.png"></a>
    </div>
    <div id="search">
        <div class="button-search"></div>
        <input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" />
    </div>
</footer>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter26527395 = new Ya.Metrika({id:26527395,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/26527395" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body></html>