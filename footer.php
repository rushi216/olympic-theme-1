<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

</div><!-- #main -->
<footer id="colophon" class="site-footer" role="contentinfo">
    <?php //get_sidebar( 'main' ); ?>
    <h2 class="text-center">Join the Fun!</h2>            
    <div>
        <div class="blue col-md-2"></div>
        <div class="yellow col-md-2"></div>
        <div class="black col-md-2"></div>
        <div class="green col-md-2"></div>
        <div class="red col-md-2"></div>
    </div>
    <div class="bottom-footer text-center">
        <p>Copyright <?php echo date('Y'); ?> Promact Infotech Pvt Ltd.All Rights Reserved</p>
    </div>  <!--bottom footer ends-->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

