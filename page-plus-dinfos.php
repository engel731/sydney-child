<?php
/**
 * page plus-d'info
 *
 * @package Sydney-child
 */

get_header(); ?>
	<?php do_action('sydney_before_content'); ?>

	<div id="primary" class="content-area <?php echo sydney_blog_layout(); ?>">
		<main id="main" class="post-wrap" role="main">

		<?php 
			// Enregistre tous les termes de la taxo type
			$terms = get_terms(array(
				'taxonomy' => 'type',
				'hide_empty' => false,
				'parent'   => 0
			))
		?>
		
		<?php if (!empty($terms) && !is_wp_error($terms)) : ?>

			<div class="taxonomy-layout row">
				<?php foreach ( $terms as $term ) : ?>
				
				<article class="taxonomy-item col-md-3" style="min-height: 380px;">
					<header class="entry-header">
						<?php 
							echo '<h4><a href="' . esc_url(get_term_link($term)) . '" rel="bookmark">' . $term->name . '</a></h4>';
						?>
					</header><!-- .entry-header -->

					<div class="entry-post">
						<p><?php echo $term->description; ?></p>
					</div>
					
					<footer class="entry-footer">
						<p>
							<?php 
							_e('Nombre d\'activités : ', 'sydney-child'); 
							echo $term->count; 
							?>
						</p>
					</footer><!-- .entry-footer -->
				</article><!-- .entry-post -->
				
				<?php endforeach; ?>
			</div>
		
		<?php else : ?>
			
			<?php get_template_part( 'content', 'none' ); ?>
		
		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php do_action('sydney_after_content'); ?>
<?php get_footer(); ?>