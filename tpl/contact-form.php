<?php
/*
	Template Name: Contact Form
*/
?>

<?php get_header(); ?>

<?php if (have_posts()) : ?>

	<div id="primary" class="fp-content-area col-md-6">
		<main id="main" class="site-main" role="main">
			<div class="entry-content">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div><!-- .entry-content -->
		</main><!-- #main -->
	</div><!-- #primary -->
		
	<div id="secondary" class="widget-area col-md-6" role="formulaire de contact">
		<?php echo do_shortcode( '[contact-form-7 id="211" title="Formulaire de contact"]' ); ?>
	</div><!-- #secondary -->
	
<?php endif; ?>

<?php get_footer(); ?>