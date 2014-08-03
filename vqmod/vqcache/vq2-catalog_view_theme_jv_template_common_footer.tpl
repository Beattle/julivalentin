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
                
			<?php foreach($headermenu as $header){?> 
			<li><a href="<?php echo $header['link'] ?>"><?php echo $header['title']; ?></a>
			<?php if($header['sub_title']){?>
				<div>	
				<ul>
				<?php foreach($header['sub_title'] as $subtitle){ ?>
				<li>
					<?php if(isset($subtitle['href'])){?>					
					<a href="<?php echo $subtitle['href']; ?>"><?php echo $subtitle['title']; ?></a>
					<?php }else{?>
					<a href="<?php echo $subtitle['link']?>"><?php echo $subtitle['title']; ?></a>	
					<?php } ?>
					<?php if($header['sub_title']){?>
				
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
			<?php foreach ($categories as $category) { ?>
		
                    <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                        <?php if ($category['children']) { ?>
                            <div>
                                <?php for ($i = 0; $i < count($category['children']);) { ?>
                                    <ul>
                                        <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
                                        <?php for (; $i < $j; $i++) { ?>
                                            <?php if (isset($category['children'][$i])) { ?>
                                                <li><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </li>
                    <?php echo $last['href'] !== $category['href']?'<hr>':null?>
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
					<?php if($menu['sub_title']){?>

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