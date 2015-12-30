        <?php global $mytheme; ?>
        <footer class="footer">
            <div class="foot_artic">
                <div class="container">
                    <div class="row">
                        <h2><span>Последние статьи в блоге</span></h2>
                    </div>
                    <div class="row">
                        <?php
                            $id=2; // ID заданной рубрики
                            $n=3;   // количество выводимых записей
                            $recent = new WP_Query("cat=$id&showposts=$n"); 
                            while($recent->have_posts()) : $recent->the_post();
                        ?>
                            <div class="col-md-4">
                                <div class="artic_item">
                                    <div class="artic_img">
                                        <a href="<?php the_permalink() ?>">
                                            <?php the_post_thumbnail(); ?>
                                        </a>
                                    </div>
                                    <div class="artic_content">
                                        <p class="zag"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
                                        <p class="date"><?php the_time('d.m.Y') ?></p>
                                        <?php $rrr = get_the_content(); ?>
                                        <p class="desc"><?php kama_excerpt("text=$rrr&maxchar=100"); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div><!-- .foot_artic -->
            <div class="foot_top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10">
                            <nav class="foot-menu">
                                <?php if(!dynamic_sidebar('menu_foot')): ?>
                        
                                <?php endif; ?>
                            </nav>
                        </div>
                        <div class="col-md-2">
                            <a href="#order" class="order">Заказать перевод</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="foot_bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <?php if(!dynamic_sidebar('copy_footer')): ?>
                        
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <p class="contact">
                                <strong>Телефон:</strong> <?php echo $mytheme['phone']; ?><br/>
                                <strong>E-mail:</strong> <?php echo $mytheme['email']; ?><br/>
                                <strong>Skype:</strong> <a href="callto:<?php echo $mytheme['skype']; ?>"><?php echo $mytheme['skype']; ?></a>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <ul class="soc-menu">
                                <li><a class="vk" target="_blank" href="<?php echo $mytheme['vk']; ?>">Вконтакте</a></li>
                                <li><a class="tw" target="_blank" href="<?php echo $mytheme['tw']; ?>">Twitter</a></li>
                                <li><a class="fb" target="_blank" href="<?php echo $mytheme['fb']; ?>">Facebook</a></li>
                                <li><a class="ok" target="_blank" href="<?php echo $mytheme['ok']; ?>">Одноклассники</a></li>
                                <li><a class="gog" target="_blank" href="<?php echo $mytheme['gog']; ?>">google +</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!-- .foot_bottom -->
        </footer>
        <?php wp_footer(); ?>
        <?php echo $mytheme['metrika']; ?>
    </body>
</html>