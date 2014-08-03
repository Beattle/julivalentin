<footer>
    <?php if ($logo) { ?>
        <div id="logo">
            <a href="<?php echo $home; ?>">
                <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
            </a>
        </div>
    <?php } ?>
    <?php // echo '<pre>' . print_r($headermenu, true) . '</pre>'; ?>
        <nav id="menu">
            <ul>
                <?php $lastKey = array_search(end($headermenu), $headermenu);reset($headermenu); ?>
                <?php foreach($headermenu as $key => $header){?>
                    <li class='level-1
                        <?php if(!empty($header['class'])){
                            echo $header['class'];
                    } ?>'><a href="<?php echo $header['link'] ?>"><?php echo $header['title']; ?></a>
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
                    <?php echo ($key !==$lastKey) ? '<li class="v-sep">':null ?>
                    <?php  ?>
                <?php  }?>
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
    <div id="social-networks"><?php echo $footer_center; ?></div>
    <div id="search">
        <div class="button-search"></div>
        <input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" />
    </div>
</footer>

</div>

</div>
</body></html>