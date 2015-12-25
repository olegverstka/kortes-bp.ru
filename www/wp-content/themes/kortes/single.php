<?php get_header(); ?>
    <main class="content">
        <div class="container">
            <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <h1><?php the_title(); ?></h1>            
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="wizivig">
                            <?php the_content(); ?>
                        </div>
                        <div class="commens-wrap">
                            <?php comments_template(); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </main>
<?php get_footer(); ?>