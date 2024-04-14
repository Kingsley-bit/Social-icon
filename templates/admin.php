<?php
// Render options page content
function custom_social_sharing_render_options_page() {
    ?>
    <div class="wrap">
        <h2>Custom Social Sharing Options</h2>
        <form method="post" action="options.php">
            <?php settings_fields('custom_social_sharing_options'); ?>
            <?php do_settings_sections('custom_social_sharing_options'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}