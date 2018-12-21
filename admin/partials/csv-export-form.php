<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/thatwpdeveloper/wp-terms-to-csv
 * @since      1.0.0
 *
 * @package    Wp_Terms_To_Csv
 * @subpackage Wp_Terms_To_Csv/admin/partials
 */
?>

<div class="wrap terms-csv">
    <h1 class="terms-csv__heading"><?php _e( 'Export Terms in CSV', 'terms-csv' ); ?></h1>
    <form class="terms-csv__form" method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
        <input name="action" type="hidden" value="<?php echo $this->plugin_name; ?>">
        <input class="terms-csv__input" type="text" name="filename" value=""
               placeholder="<?php _e( 'Filename (optional)', 'terms-csv' ); ?>">
        <input class="terms-csv__submit" type="submit" value="<?php _e( 'Export', 'terms-csv' ); ?>">
    </form>
</div>
