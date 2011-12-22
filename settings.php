<?php

// Adding options page
function slides_menu() {
	add_options_page('jQuery Slides','jQuery Slides','manage_options','slides_options','slides_options');
}
add_action('admin_menu', 'slides_menu');

function slides_options(){
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	?>
	<form action="options.php" method="post">
	  <div class="wrap">
		<?php wp_nonce_field('update-options') ?>
		  <h2>jQuery Slider Settings</h2>
		  <table border="0" cellspacing="6" cellpadding="6">
			<tr>
			  <td>Width</td>
			  <td><input name="slides_width" type="text" id="slides_width" value="<?php echo get_option('slides_width'); ?>" size="5" />px</td>
			</tr>
			<tr>
			  <td>Height</td>
			  <td><input name="slides_height" type="text" id="slides_height" value="<?php echo get_option('slides_height'); ?>" size="5" />px</td>
			</tr>
			<tr>
			  <td>Pause on hover</td>
			  <td>
			  <select name="slides_pause" id="slides_pause">
				<option value="true" <?php if(get_option('slides_pause') == 'true') echo "selected" ?>>Yes</option>
				<option value="false" <?php if(get_option('slides_pause') == 'false') echo "selected" ?>>No</option>
			  </select></td>
			</tr>
			<tr>
			  <td>Show pagination</td>
			  <td>
			  <select name="slides_pagination" id="slides_pagination">
				<option value="true" <?php if(get_option('slides_pagination') == 'true') echo "selected" ?>>Yes</option>
				<option value="false" <?php if(get_option('slides_pagination') == 'false') echo "selected" ?>>No</option>
			  </select></td>
			</tr>
			<tr>
			  <td>Show navigation</td>
			  <td>
			  <select name="slides_navigation" id="slides_navigation">
				<option value="true" <?php if(get_option('slides_navigation') == 'true') echo "selected" ?>>Yes</option>
				<option value="false" <?php if(get_option('slides_navigation') == 'false') echo "selected" ?>>No</option>
			  </select></td>
			</tr>
			<tr>
			  <td>Slideshow delay</td>
			  <td><input name="slides_delay" type="text" id="slides_delay" value="<?php echo get_option('slides_delay'); ?>" size="5" />sec</td>
			</tr>
			<tr>
			  <td>Pause slideshow delay</td>
			  <td><input name="slides_pause_delay" type="text" id="slides_pause_delay" value="<?php echo get_option('slides_pause_delay'); ?>" size="5" />sec</td>
			</tr>
			<tr>
			  <td>Effect</td>
			  <td>
			  <select name="slides_effect" id="slides_effect">
				<option value="fade" <?php if(get_option('slides_effect') == 'fade') echo "selected" ?>>fade</option>
				<option value="slide" <?php if(get_option('slides_effect') == 'slide') echo "selected" ?>>slide</option>
			  </select></td>
			</tr>
			<tr>
			  <td>Crossfade</td>
			  <td>
			  <select name="slides_crossfade" id="slides_crossfade">
				<option value="true" <?php if(get_option('slides_crossfade') == 'true') echo "selected" ?>>Yes</option>
				<option value="false" <?php if(get_option('slides_crossfade') == 'false') echo "selected" ?>>No</option>
			  </select></td>
			</tr>
			<tr>
			  <td>Class prefix</td>
			  <td><input name="slides_class_prefix" type="text" id="slides_class_prefix" value="<?php echo get_option('slides_class_prefix'); ?>" size="5" /></td>
			</tr>
            <tr>
			  <td>&nbsp;</td>
			  <td><span class="submit">
			  <input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="slides_width,slides_height,slides_pause,slides_pagination,slides_navigation,slides_delay,slides_effect,slides_crossfade,slides_class_prefix" />
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			  </span></td>
			</tr>
		  </table>
		</div>
	</form>
	<?php
}
