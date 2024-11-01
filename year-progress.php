<?php
/*
Plugin Name: Year Progress Bar
Plugin URI: https://gorewada.com/
Description: This plugin will display year, month, and day progress bar.
Author: Mike Irvine
Version: 2.0
Author URI: https://www.gorewada.com/
Donate link: https://www.buymeacoffee.com/mikeirvine/
Text Domain: YPBP_year-progress
Domain Path: /languages
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// Register custom REST API endpoint
function ypbp_register_rest_endpoint() {
    register_rest_route( 'ypbp/v1', '/year-progress', array(
        'methods'  => 'GET',
        'callback' => 'ypbp_get_year_progress_data',
    ));
}
add_action( 'rest_api_init', 'ypbp_register_rest_endpoint' );

// Callback function for the custom endpoint
function ypbp_get_year_progress_data( $request ) {
    // Perform logic to retrieve year progress data
    $year_progress = ypbp_calculate_year_progress(); // Replace with your logic
    
    // Return the year progress data as a response
    return rest_ensure_response( $year_progress );
}

// Custom logic to calculate year progress
function ypbp_calculate_year_progress() {
    // Implement your calculation logic to determine the year progress
    // You can use date functions or other calculations as per your requirements
    
    // For example, calculate the year progress as a percentage
    $current_date = new DateTime();
    $start_date = new DateTime( date( 'Y-01-01' ) );
    $end_date = new DateTime( date( 'Y-12-31' ) );
    
    $year_duration = $end_date->diff( $start_date )->days;
    $days_passed = $current_date->diff( $start_date )->days;
    
    $progress_percentage = ( $days_passed / $year_duration ) * 100;
    
    return round( $progress_percentage, 2 );
}

// Enqueue necessary scripts and styles
function ypbp_enqueue_scripts() {
    // Enqueue html2canvas.js library
    wp_enqueue_script( 'html2canvas', plugin_dir_url( __FILE__ ) . 'app/html2canvas.js', array(), '1.0.0', true );
    
    // Enqueue custom script
    wp_enqueue_script( 'ypbp-year-progress', plugin_dir_url( __FILE__ ) . 'app/yProgress.js', array( 'html2canvas' ), '1.0.0', true );
    
    // Enqueue custom styles
    wp_enqueue_style( 'ypbp-year-progress-styles', plugin_dir_url( __FILE__ ) . 'app/ypbpstyle.css', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'ypbp_enqueue_scripts' );

// Widget initialization
function ypbp_year_progress_widget_init() {
    register_sidebar_widget( __('Year Progress Bar', 'YPBP_year-progress'), 'ypbp_year_progress_widget' );
    register_widget_control( __('Year Progress Bar', 'YPBP_year-progress'), 'ypbp_year_progress_widget_control' );
}
add_action( 'widgets_init', 'ypbp_year_progress_widget_init' );

// Widget display function
function ypbp_year_progress_widget( $args ) {
    extract( $args );
    echo esc_html($before_widget);
    echo esc_html($before_title) . esc_html(__('Year Progress Bar', 'YPBP_year-progress')) . esc_html($after_title);
    ypbp_year_progress_show();
    echo esc_html($after_widget);
}

// Widget control form
function ypbp_year_progress_widget_control() {
    // Widget control form logic goes here
}

// Display the Year Progress Bar
function ypbp_year_progress_show() {
    $py = ypbp_year_progress();
    $pm = get_month_progress();

    ?>

    <div id="capture">
        <div id="year-progress">
            <h3><?php echo esc_html__('Year Progress', 'YPBP_year-progress'); ?>:<?php echo "&nbsp;" . esc_html(date('Y')); ?></h3>
        </div>
        
        <div class="meter animate" id="year">
            <span style="width: <?php echo esc_html(round($py)); ?>%;">
                
                <div align="right" style="color: white !important;font-style: oblique;font-weight: 800;">
                   <span> <?php echo esc_html(round($py)); ?>%</span>
                </div>
            </span>
        </div>

        <div id="month-progress" class="month-progress hidden">
            <h3><?php echo esc_html__('Month Progress', 'YPBP_year-progress'); ?>:<?php echo "&nbsp;" . esc_html(date('F')); ?></h3>
        </div>

        <div class="meter animate hidden" id="month">
            <span style="width: <?php echo esc_attr(round($pm)); ?>%;">
                <span></span>
                <div align="right" style="color: white !important;font-style: oblique;font-weight: 800;">
                    <?php echo esc_html(round($pm)); ?>%
                </div>
            </span>
        </div>
    </div>

   <!-- <form>
    <div class="form-group">
        <label for="year-progress-select">Progress Type</label>
        <select id="year-progress-select" name="year-progress-select" onchange="changeProgressType()">
            <option value="year">Year Progress</option>
            <option value="month">Month Progress</option>
        </select>
    </div>
    <div class="form-group">
        <input id="btn-Preview-Image" type="button" value="Preview" onclick="showDownload()"/> 
</form> -->

<!-- <script>
function showDownload() {
    // Code to handle the button click event
    // Replace with your logic to show download or perform other actions
    // For example:
    var progressType = document.getElementById('year-progress-select').value;
    if (progressType === 'year') {
        // Show Year progress download logic here
        alert("Year progress download logic");
    } else if (progressType === 'month') {
        // Show Month progress download logic here
        alert("Month progress download logic");
    }
}
</script> -->

<br />

<div id="previewImage" class="previewImage hidden">
<a id="btn-Convert-Html2Image" href="#"><?php _e('Download', 'YPBP_year-progress'); ?></a>
</div>


<?php
}

// Calculate year progress
function ypbp_year_progress() {
    $year = date("Y");
    $days_now = date("z") + 1;
    $days_year = ypbp_cal_days_in_year($year);
    $remaining_days = $days_year - $days_now;
    $year_progress = ( $remaining_days / $days_year ) * 100;
    return 100 - $year_progress;
}

// Calculate month progress
function get_month_progress() {
    $current_day = date("d");
    $days_in_month = date("t");
    $month_progress = ( $days_in_month - $current_day ) / $days_in_month * 100;
    return 100 - $month_progress;
}

// Calculate days in a year
function ypbp_cal_days_in_year($year) {
    $days = 0;
    for ($month = 1; $month <= 12; $month++) {
        $days += cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }
    return $days;
}

// Add color and style settings to plugin admin panel
function ypbp_year_progress_add_settings() {
    add_options_page(__('Year Progress Bar', 'YPBP_year-progress'), __('Year Progress Bar', 'YPBP_year-progress'), 'manage_options', 'YPBP_year-progress', 'ypbp_year_progress_management');
    add_action('admin_init', 'ypbp_year_progress_register_settings');
}
add_action('admin_menu', 'ypbp_year_progress_add_settings');

// Register settings
function ypbp_year_progress_register_settings() {
    register_setting('ypbp_year_progress_settings', 'ypbp_year_progress_bar_color');
    register_setting('ypbp_year_progress_settings', 'ypbp_year_progress_bar_style');
}

// Append custom styles to the plugin's CSS file
function ypbp_year_progress_custom_styles() {
    $bar_color = get_option('ypbp_year_progress_bar_color', '#3498db');
    $bar_style = get_option('ypbp_year_progress_bar_style', 'solid');

    $custom_styles = "
        .meter.animate span {
            background-color: {$bar_color};
            box-shadow: 0 0 10px {$bar_color};
        }
    ";

    if ($bar_style === 'striped') {
        $custom_styles .= "
            .meter.animate span:before,
            .meter.animate span:after {
                background-color: {$bar_color};
            }
        ";
    }

    wp_add_inline_style('ypbp-year-progress-styles', $custom_styles);
}
add_action('wp_enqueue_scripts', 'ypbp_year_progress_custom_styles');

// Plugin menu page content
function ypbp_year_progress_management() {
    ?>
    <div class="wrap">
        <h2><?php _e('Year Progress Bar 2.0', 'YPBP_year-progress'); ?></h2>
        <h3><?php _e('How to use Year Progress Bar 2.0', 'YPBP_year-progress'); ?></h3>
        <ol>
            <li><?php _e('Go to Appearance -> Widgets (Drag Year Progress Bar from available Widgets to Side bar).', 'YPBP_year-progress'); ?></li>
            <h3><?php _e('Or', 'YPBP_year-progress'); ?></h3>
            <li><?php _e('Paste this code in your theme.', 'YPBP_year-progress'); ?></li>
        </ol>
        <h3><?php _e('Following new features will be included in Year Progress Bar Pro', 'YPBP_year-progress'); ?></h3>
        <ol>
           <s><li><?php _e('Customization of Progress Bar as per color and style.', 'YPBP_year-progress'); ?></li></s>
            <li><?php _e('Day start and end settings.', 'YPBP_year-progress'); ?></li>
            <li><?php _e('Special announcement messages with Progress Bar like Age, Birthday, Black Friday offer.', 'YPBP_year-progress'); ?></li>
            <li><?php _e('Custom Progress Bar with custom deadlines. Write a name with emoji and set a start date and end date.', 'YPBP_year-progress'); ?></li>
            <li><?php _e('Shortcode to make it easy to add anywhere on your website.', 'YPBP_year-progress'); ?></li>
            <li><?php _e('One-click Twitter share and other social networks.', 'YPBP_year-progress'); ?></li>
            <li><?php _e('Some more secret features to be disclosed later.', 'YPBP_year-progress'); ?></li>
        </ol>
        <p class="description">
            <?php _e('If you like the Plugin, I deserve a Coffee, and you will be the first to get the new paid version for free.', 'YPBP_year-progress'); ?>
        </p>

        <script type="text/javascript" src="https://cdnjs.buymeacoffee.com/1.0.0/button.prod.min.js" data-name="bmc-button" data-slug="mikeirvine" data-color="#FFDD00" data-emoji=""  data-font="Cookie" data-text="Buy me a coffee" data-outline-color="#000000" data-font-color="#000000" data-coffee-color="#ffffff" ></script>
        
        <form method="post" action="options.php">
            <?php settings_fields('ypbp_year_progress_settings'); ?>
            <?php do_settings_sections('YPBP_year-progress'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e('Bar Color', 'YPBP_year-progress'); ?></th>
                    <td><input type="color" name="ypbp_year_progress_bar_color" value="<?php echo esc_attr(get_option('ypbp_year_progress_bar_color', '#3498db')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Bar Style', 'YPBP_year-progress'); ?></th>
                    <td>
                        <select name="ypbp_year_progress_bar_style">
                            <option value="solid" <?php selected(get_option('ypbp_year_progress_bar_style', 'solid'), 'solid'); ?>><?php _e('Solid', 'YPBP_year-progress'); ?></option>
                            <option value="striped" <?php selected(get_option('ypbp_year_progress_bar_style', 'solid'), 'striped'); ?>><?php _e('Striped', 'YPBP_year-progress'); ?></option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
