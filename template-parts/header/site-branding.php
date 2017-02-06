<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-branding" style="">
	<div class="wrap">

		<?php the_custom_logo(); ?>

		<div class="site-branding-text">
			<?php if ( is_front_page() ) : ?>
                            <div class="col-md-12 text-center bg-cover" >
                            <img class="logo" alt="logo" src="<?php echo get_theme_root_uri()?>/<?php echo get_option( 'stylesheet' ) ?>/assets/images/logo.png">

                                <h1 class="olympics-title">PROMACT OLYMPICS</h1>
                                <h2 class="olympics-date"><?php echo date("Y"); ?> </h2>
                                <h2 class="battle-start">Battle has begun.!! Enjoy !!</h2>
                                <img class="angle-down" src="<?php echo get_theme_root_uri()?>/<?php echo get_option( 'stylesheet' ) ?>/assets/images/angle-icon-down.png">
                            </div>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif; ?>

			<!--<?php $description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; ?></p>
				<?php endif; ?>-->
		</div><!-- .site-branding-text -->

		<?php if ( ( twentyseventeen_is_frontpage() || ( is_home() && is_front_page() ) ) && ! has_nav_menu( 'top' ) ) : ?>
		<a href="#content" class="menu-scroll-down"><?php echo twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ); ?><span class="screen-reader-text"><?php _e( 'Scroll down to content', 'twentyseventeen' ); ?></span></a>
	<?php endif; ?>

	</div><!-- .wrap -->
</div><!-- .site-branding -->
