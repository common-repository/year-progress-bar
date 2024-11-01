<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly?>
<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>


<div class="wrap">
    	<!-- <div id="icon-edit" class="icon32 icon32-posts-post"></div> -->
   		<h2><?php _e('Year Progress Bar 1.0', 'YPBP_year-progress'); ?></h2>
       	<h3><?php _e('How to use Year Progress Bar 1.0', 'YPBP_year-progress'); ?></h3>
		<ol>
			<li><?php _e('Go to Appearance->Widgets (Drag Year Progress Bar from available Widgets to Side bar).', 'YPBP_year-progress'); ?></li>
			<h3><?php _e('Or', 'YPBP_year-progress'); ?></h3>
			<?php $source = show_source("use.txt", true);?>
			<li><?php print $source;?><?php _e('Paste this code in your theme.', 'YPBP_year-progress'); ?></li>
		</ol>
		
		<h3><?php _e('Following new features will be included in Year Progress Bar Pro', 'YPBP_year-progress'); ?></h3>
		<ol>
			<li><?php _e('Customization of Progress Bar as per color and style.', 'YPBP_year-progress'); ?></li>
			<li><?php _e('Day start and end settings.', 'YPBP_year-progress'); ?></li>
			<li><?php _e('Special announcement messages with Progress Bar like Age, Birthday, Black friday offer.', 'YPBP_year-progress'); ?></li>
			<li><?php _e('Custom Progress Bar with custom deadlines. Write a name with emoji and set a start date and end date.', 'YPBP_year-progress'); ?></li>
			<li><?php _e('Short code to make it easy to add anywhere on your website.', 'YPBP_year-progress'); ?></li>
			<li><?php _e('One click twitter share and other social networks.', 'YPBP_year-progress'); ?></li>
			<li><?php _e('Some more secret features do be disclosed later.', 'YPBP_year-progress'); ?></li>
		</ol>
		<p class="description">
			<?php _e('If you like the Plugin, I deserve a Coffee and you will be the first to get the new paid version for free.', 'YPBP_year-progress'); ?>
		</p>
	<a id="bmac" href="<?php echo esc_url(WP_YPBP_year_FAV); ?>" target="_blank">
		<div id="buymecoffee" style="position:relative;">
		</div>
	</a>
</div>