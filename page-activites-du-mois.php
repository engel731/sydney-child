<?php
/**
 *
 * @package Sydney child
 */

get_header(); ?>
	<?php do_action('sydney_before_content'); ?>

	<div id="primary" class="content-area col-md-12">
		<main id="main" class="post-wrap" role="main">

			<?php $the_query = new WP_Query(array(
				'post_type' => 'event',
				'posts_per_page' => 10
			)); ?>

			<?php if($the_query->have_posts()) : ?>

			<section class="table-responsive">
				<table class="table table-bordered table-condensed">
					<caption>
						<?php the_title( '<h4 class="title-post entry-title">', '</h4>' ); ?>
					</caption>
					
					<thead>
						<tr>
							<th>Date de l'évenement</th>
							<th>Titre</th>
							<th>Description</th>
							<th>Inscription</th>
						</tr>
					</thead>
				
					<tbody>
						
						<?php while($the_query->have_posts()): $the_query->the_post(); ?>
							<tr class="lign">
								<td><?php echo date('d/m/y', strtotime(get_post_meta($post->ID, '_date_event', true))); ?></td>
								<td>
									<?php the_title( 
										sprintf(
											'<a href="%s" rel="bookmark">', 
											esc_url(get_permalink(get_post_meta($post->ID, '_activity_id', true)))
										), 
										'</a>' 
									); ?>
								</td>
								<td><?php the_content(); ?></td>
								<td>
									<a class="btn btn-default" href="#">S'inscrire</a>
								</td>
							</tr>
							
						<?php endwhile; // end of the loop. ?>
						<?php wp_reset_postdata(); ?>
					</tbody>
				</table>
			</section>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			<footer class="entry-footer">
				<?php edit_post_link( __( 'Edit', 'sydney' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-footer -->
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php do_action('sydney_after_content'); ?>
<?php get_footer(); ?>