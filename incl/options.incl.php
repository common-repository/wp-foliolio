<div class="wrap">
<h2>WP-Foliolio Settings</h2><img class="folioliologo" src='<?php echo $this->pluginUrl; ?>/img/WP-Foliolio-web.png' alt="WP-Foliolio Logo" title="WordPress Foliolio Plugin logo" />
<form method="post" action="options.php">
    <?php settings_fields( self::WP_OPTION_GROUP ); ?>
	<h3>General Options</h3>
    <div class="folioliodiv">
	<table class="form-table">
        
	</table>
	<h3>Projects Page Options</h3>
	<table class="form-table">
		<tr valign="top">
        <th scope="row">Title of Projects Page</th>
        <td><input type="text" name="wpfo_projects_title" value="<?php echo get_option('wpfo_projects_title'); ?>" /></td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Show project title <br /><small>(above each project)</small></th>
        <td><input type="checkbox" name="wpfo_projects_showtitle" <?php echo get_option('wpfo_projects_showtitle') == 'on' ? 'checked="checked"' : '';  ?>/></td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Show project information <br /><small>(below each project)</small></th>
        <td><input type="checkbox" name="wpfo_projects_postmeta" <?php echo get_option('wpfo_projects_postmeta') == 'on' ? 'checked="checked"' : '';  ?>/></td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Show "Platforms" <br /><small>(below each project)</small></th>
        <td><input type="checkbox" name="wpfo_projects_platform" <?php echo get_option('wpfo_projects_platform') == 'on' ? 'checked="checked"' : '';  ?>/></td>
        </tr>
    </table>

    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
	</div>

</form>
</div>