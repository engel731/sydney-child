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

		<?php $the_query = new WP_Query(array(
			'post_type' => 'activity'
		)); ?>

		<?php if($the_query->have_posts()) : ?>
	
		<div class="posts-layout row">
			<?php while($the_query->have_posts()): $the_query->the_post(); ?>
				
				<div style="height:900px;" class="col-md-3">
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