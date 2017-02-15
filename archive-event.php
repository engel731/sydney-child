<?php
/**
 * Evénemment archives template
 *
 * @package Sydney-child
 */

get_header(); ?>
	<?php do_action('sydney_before_content'); ?>

	<div id="primary" class="content-area <?php echo sydney_blog_layout(); ?>">
		<main id="main" class="post-wrap" role="main">

		<?php if ( have_posts() ) : ?>

		<div class="posts-layout">
			<?php while ( have_posts() ) : the_post(); ?>
				<header class="entry-header">
					<?php 
						$activity = get_post_meta($post->ID, '_activity_id', true);
						
						the_title( 
							sprintf(
								'<h3 class="title-post entry-title"><a href="%s" rel="bookmark">', 
								esc_url(get_permalink($activity))
							), 
							'</a></h3>' 
						); 
					?>

					<div class="meta-post">
						<?php sydney_posted_on(); ?>
					</div><!-- .entry-meta -->
				</header><!-- .entry-header -->
			<?php endwhile; ?>
		</div>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	
	<?php do_action('sydney_after_content'); ?>
<?php get_footer(); ?>

