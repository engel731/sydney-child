<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Sydney-child
 */
?>
						</div>
					</div>
				</div><!-- #content -->

				<?php do_action('sydney_before_footer'); ?>

				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<?php get_sidebar('footer'); ?>
				<?php endif; ?>

    			<a class="go-top"><i class="fa fa-angle-up"></i></a>
		
				<footer id="colophon" class="site-footer" role="contentinfo">
					<div class="site-info container">
						<span><?php _e('Tous droits réservés - 2016 - Bazire Tanguy', 'sydney-child'); ?></span>
						<span class="sep"> | </span>
						<a href="#"><?php _e('Condition générale d\'utilisation,', 'sydney-child'); ?> </a>
						<a href="#"><?php _e('Mention Légales', 'sydney-child'); ?></a>
					</div><!-- .site-info -->
				</footer><!-- #colophon -->

				<?php do_action('sydney_after_footer'); ?>
			</div><!-- #page -->
		<?php wp_footer(); ?>
	</body>
</html>