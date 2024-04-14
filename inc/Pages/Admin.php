<?php
/**
 * @package Custom Social Sharing
 */
namespace inc\Pages;


use \inc\Base\BaseController;
class Admin extends BaseController {
    
public function register(){
    add_action('admin_menu', array($this,'custom_social_sharing_options_page' ));
    add_filter('the_content', array($this,'custom_social_sharing_buttons'));
    add_action('admin_init', array($this, 'custom_social_sharing_initialize_settings'));
}  
// Add options page
function custom_social_sharing_options_page() {
    add_options_page(
        'Custom Social Sharing Options',
        'Social Sharing',
        'manage_options',
        'custom-social-sharing-options',
        array($this, 'custom_social_sharing_render_options_page')
        );
        //require_once $this->plugin_path . 'templates/admin.php';
        
}  
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

// Initialize settings
function custom_social_sharing_initialize_settings() {
    register_setting(
        'custom_social_sharing_options',
        'custom_social_sharing_options',
        array($this, 'custom_social_sharing_validate_options') 
    );

    add_settings_section(
        'custom_social_sharing_main_section',
        'Social Sharing Settings',
       array($this, 'custom_social_sharing_main_section_callback'),
        'custom_social_sharing_options'
    );

    add_settings_field(
        'custom_social_sharing_enable',
        'Enable Social Sharing',
       array($this, 'custom_social_sharing_enable_callback'),
        'custom_social_sharing_options',
        'custom_social_sharing_main_section'
    );

    add_settings_field(
        'custom_social_sharing_networks',
        'Select Social Networks',
        array($this,'custom_social_sharing_networks_callback'),
        'custom_social_sharing_options',
        'custom_social_sharing_main_section'
    );
    add_settings_field(
        'custom_social_sharing_style',
        'Select Button Style',
        array($this,'custom_social_sharing_style_callback'),
        'custom_social_sharing_options',
        'custom_social_sharing_main_section'
    );
    add_settings_field(
        'custom_social_sharing_labels',
        'Custom Button Labels',
        array($this,'custom_social_sharing_labels_callback'),
        'custom_social_sharing_options',
        'custom_social_sharing_main_section'
    );

    add_settings_field(
        'custom_social_sharing_css_classes',
        'Custom CSS Classes',
        array($this,'custom_social_sharing_css_classes_callback'),
        'custom_social_sharing_options',
        'custom_social_sharing_main_section'
    );

    add_settings_field(
        'custom_social_sharing_tracking',
        'Event Tracking',
        array($this,'custom_social_sharing_tracking_callback'),
        'custom_social_sharing_options',
        'custom_social_sharing_main_section'
    );
}


// Validate options
function custom_social_sharing_validate_options($input) {
    $output = array();
    $output['enable'] = (isset($input['enable']) && $input['enable'] == 1) ? 1 : 0;
    if (isset($input['networks']) && is_array($input['networks'])) {
        foreach ($input['networks'] as $key => $value) {
            $output['networks'][$key] = $value ? 1 : 0;
        }
    }
    $valid_styles = array(
        'default' => 'Default',
        'rounded' => 'Rounded',
        'outlined' => 'Outlined',
        // Add more button styles here
    );

    if (isset($input['style']) && array_key_exists($input['style'], $valid_styles)) {
        $output['style'] = $input['style'];
    } else {
        $output['style'] = 'default'; // Default style if no valid style is selected
    }
    if (isset($input['labels']) && is_array($input['labels'])) {
        foreach ($input['labels'] as $key => $value) {
            // Sanitize each label value
            $output['labels'][$key] = sanitize_text_field($value);
        }
    }
    // Validate and sanitize custom CSS classes
    if (isset($input['css_classes'])) {
        // Sanitize the input to remove any potentially harmful content
        $output['css_classes'] = sanitize_text_field($input['css_classes']);
    }
    if (isset($input['tracking'])) {
        // Ensure that the value is either 1 or 0
        $output['tracking'] = $input['tracking'] ? 1 : 0;
    }

    return $output;
}



// Callback for main section
function custom_social_sharing_main_section_callback() {
    echo '<p>Customize the appearance and behavior of the social sharing buttons.</p>';
}

// Callback for enable option
function custom_social_sharing_enable_callback() {
    $options = get_option('custom_social_sharing_options');
    echo '<input type="checkbox" id="custom_social_sharing_enable" name="custom_social_sharing_options[enable]" value="1" ' . checked(1, $options['enable'], false) . ' />';
}
// Add social networks selection field
function custom_social_sharing_networks_callback() {
    $options = get_option('custom_social_sharing_options');
    $networks = array(
        'F' => 'Facebook',
        'X' => 'Twitter',
        // Add more social networks here
    );

    foreach ($networks as $key => $label) {
         $checked = isset($options['networks'][$key]) && $options['networks'][$key] ? 'checked' : '';
        echo '<label><input type="checkbox" name="custom_social_sharing_options[networks][' . $key . ']" value="1" ' . $checked . ' />' . $label . '</label><br>';
    }
}

// Add button style selection field
function custom_social_sharing_style_callback() {
    $options = get_option('custom_social_sharing_options');
    $styles = array(
        'default' => 'Default',
        'rounded' => 'Rounded',
        'outlined' => 'Outlined',
        // Add more button styles here
    );

    echo '<select name="custom_social_sharing_options[style]">';
    foreach ($styles as $key => $label) {
        echo '<option value="' . $key . '" ' . selected($options['style'], $key, false) . '>' . $label . '</option>';
    }
    echo '</select>';
}
// Add custom button labels field
function custom_social_sharing_labels_callback() {
    $options = get_option('custom_social_sharing_options');
    $labels = array(
        'facebook' => 'Facebook Label',
        'twitter' => 'Twitter Label',
        // Add more social networks here
    );

   // Check if the 'labels' key exists in the options array
   $options_labels = isset($options['labels']) ? $options['labels'] : array();

   foreach ($labels as $key => $label) {
       // Use isset() to avoid accessing undefined array keys
       $value = isset($options_labels[$key]) ? esc_attr($options_labels[$key]) : '';
       echo '<label for="custom_social_sharing_label_' . $key . '">' . $label . ': </label>';
       echo '<input type="text" id="custom_social_sharing_label_' . $key . '" name="custom_social_sharing_options[labels][' . $key . ']" value="' . $value . '" /><br>';
   }
}

// Add custom CSS classes field
function custom_social_sharing_css_classes_callback() {
    $options = get_option('custom_social_sharing_options');
    echo '<input type="text" id="custom_social_sharing_css_classes" name="custom_social_sharing_options[css_classes]" value="' . esc_attr($options['css_classes']) . '" />';
    echo '<p class="description">Add custom CSS classes to the social sharing buttons container. Separate multiple classes with spaces.</p>';
}

// Add event tracking field
function custom_social_sharing_tracking_callback() {
    $options = get_option('custom_social_sharing_options');
    $tracking_checked = isset($options['tracking']) && $options['tracking'] ? 'checked' : '';

    echo '<label><input type="checkbox" id="custom_social_sharing_tracking" name="custom_social_sharing_options[tracking]" value="1" ' . $tracking_checked . ' /> Enable Event Tracking</label>';
    echo '<p class="description">Track social sharing events using Google Analytics or other analytics tools.</p>';
}


// Add additional settings fields as needed


// Add social sharing buttons based on options
function custom_social_sharing_buttons($content) {
    $options = get_option('custom_social_sharing_options');
    if ($options['enable'] && is_singular()) { // Display only if enabled and on single post/page
        $buttons_html = '<div class="custom-social-sharing ' . esc_attr($options['css_classes']) . ' social-icons-container">';

        $networks = $options['networks'];
        foreach ($networks as $network => $enabled) {
            if ($enabled) {
                $label = !empty($options['labels'][$network]) ? $options['labels'][$network] : ucfirst($network);
                switch ($network) {
                    case 'F':
                        $url = 'https://www.facebook.com/sharer/sharer.php?u=' . get_permalink();
                        break;
                    case 'X':
                        $url = 'https://twitter.com/intent/tweet?url=' . get_permalink();
                        break;
                    // Add more cases for other social networks here
                    default:
                        $url = '';
                        break;
                }
                if (!empty($url)) {
                    // Generate HTML for both button and label
                    $buttons_html .= '<div class="social-icon-wrapper">';
                    $buttons_html .= '<a href="' . esc_url($url) . '" target="_blank" class="social-icon ' . esc_attr($options['style']) . '">' . esc_html($network) . '</a>';
                    $buttons_html .= '<span class="social-icon-label">' . esc_html($label) . '</span>';
                    $buttons_html .= '</div>';
                }
            }
        }

        $buttons_html .= '</div>';

        $content .= $buttons_html;
    }
    return $content;
}
}