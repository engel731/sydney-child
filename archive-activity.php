<?php
/**
 * Activite archives template
 *
 * @package Sydney-child
 */

get_header(); ?>
	<?php do_action('sydney_before_content'); ?>

	<div id="primary" class="content-area <?php echo sydney_blog_layout(); ?>">
		<main id="main" class="post-wrap" role="main">

		<?php if ( have_posts() ) : ?>

		<div class="posts-layout row">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="activity-item col-md-3">
					<?php get_template_part( 'content', get_post_format() ); ?>
				</div>
			<?php endwhile; ?>
		</div>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php do_action('sydney_after_content'); ?>
<?php get_footer(); ?>