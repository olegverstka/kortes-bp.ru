<?php get_header(); ?>
    <main class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php single_cat_title(); ?></h1>            
                </div>
            </div>
            <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
                <div class="row">
                    <div class="col-md-2">
                        <a href="<?php the_permalink() ?>">
                            <?php the_post_thumbnail(); ?>
                        </a>
                    </div>
                    <div class="col-md-10">
                        <p class="zag"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
                        <p class="date"><?php the_time('d.m.Y') ?></p>
                        <?php $rrr = get_the_content(); ?>
                        <p class="desc"><?php kama_excerpt("text=$rrr&maxchar=200"); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </main>
<?php get_footer(); ?>