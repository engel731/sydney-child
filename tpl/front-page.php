<?php
/*
Template Name: Front Page
*/

get_header(); ?>
	
	<div id="primary" class="fp-content-area col-md-7">
		<main id="main" class="site-main" role="main">
			<div class="entry-content">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div><!-- .entry-content -->
		</main><!-- #main -->
		
		<div class="row">
			<div class="col-md-6">
				<?php wp_nav_menu(array('theme_location' => 'second_menu')); ?>
			</div>
		</div>
	</div><!-- #primary -->
	
	<div id="secondary" class="widget-area col-md-5" role="complementary">
		<?php dynamic_sidebar('sidebar_index'); ?>
	</div><!-- #secondary -->
	
<?php get_footer(); ?>