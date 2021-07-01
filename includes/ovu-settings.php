<?php

/**
 * INTENT:     OVU ADMIN PAGE SETTINGS HTML
 * CREATED v1: December 17, 2017
 * UPDATED v2: June 21, 2021 added support for css vw and vh units.
 * AUTHOR:     Clinton Gallagher. All Rights Reserved.
 * NOTE:       The ovu prefix is an acronym of onBrowser Resize Viewport Units
 */

// CREATE MENU LINK
function ovu_options_menu_link(){
	add_options_page(
		'Viewport Units',
		'Viewport Units',
		'manage_options',
		'ovu-options',
		'ovu_options_content');
}

// CREATE OPTIONS PAGE CONTENT
function ovu_options_content(){

    // INITIALIZE GLOBAL FORM SETTINGS OPTIONS VARIABLE
	global $ovu_options;

	// START AN OUTPUT BUFFER
	ob_start(); ?>
	<div class="wrap">
        <!--SETTINGS PAGE TITLE-->
		<h2 style="white-space: nowrap;">
            <?php _e('Responsive Viewport Units Settings', 'ovu_domain');?>
        </h2>
        <!--PLUGIN DESCRIPTION-->
        <div class="ovu-description_plugin">
		<p>
            <?php _e('The Responsive Viewport Units plugin displays the window.innerWidth and window.innerHeight viewport unit properties when the browser is resized. Unit properties are displayed in pixel and rem units.', 'ovu_domain');?>
        </p>
        <p style="margin-top:0;">
			<?php _e('Default properties are preset. To modify properties use the numerical input to change the value for the bottom margin as may be required to move the units container vertically up or down in the pages of the website where it will be displayed. Click a color picker to select a color for each property of the units container for optimal readability with the theme being used. A cookie and localStorage are used to maintain state. Refresh the website page to apply modifications to the container. The Viewport Units will remain displayed on every page of the website while the plugin remains activated.', 'ovu_domain');?>
        </p>
        </div>

        <!--EXAMPLE OF VIEWPORT UNITS CONTAINER-->
		<div class="ovu-description_example-output">973px (60.8125rem)W  x  478px (29.875rem)H</div>
		<p class="ovu-description_example-output-caption"><?php _e('Example viewport units container output', 'ovu_domain');?></p>

        <!--FORM: UNIT SETTINGS -->
        <form id="colorPickerForm"  method="post" action="options.php" class="form-validation">

	        <?php settings_fields('ovu_settings_group'); ?>

            <table border="0" class="ovu-settings-table">
                <tbody>
                <!--BOTTOM MARGIN-->
                <tr class="ovu-vertical-align">
                    <td class="ovu-settings-label"><?php _e('Bottom Margin', 'ovu_domain');?></td>
                    <td class="ovu-settings-color-picker ovu-margin-bottom-controller">
                        <input id="ovu_margin_bottom"
                               name="ovu_margin_bottom"

                               type="number"
                               min="0"
                               value="0"
                               title="<?php _e('Select a value to set the bottom margin of the units container.', 'ovu_domain');?>"
                               required
                               onkeydown="return false"><span class="valid-input"></span>
                        <p class="ovu-description_bottom-margin-caption">
                            <label for="ovu_margin_bottom" title="Vertically moves the display of the Viewport Units container up or down.">
                            <?php _e('Default = "0" '); ?>
                            </label>
                        </p>
                    </td>
                </tr>
                <!--BACKGROUND COLOR-->
                <tr class="ovu-vertical-align ovu-settings-color-picker-row">
                    <td class="ovu-settings-label"><?php _e('Background Color', 'ovu_domain');?></td>
                    <td class="ovu-settings-color-picker">
                        <div id="ovu_settings_background_color">
                            <!--class="color" affects no changes if removed-->
                            <a class="color"  title="<?php _e('Select a background color for the units container.','ovu_domain') ?>">
                                <div id="ovu_inner_background_color" class="colorInner"></div>
                            </a>
                            <div class="track"></div>
                            <ul class="dropdown"><li></li></ul>
                            <input id="hidden-input-background-color"
                                   name="hidden-input-background-color"
                                   type="hidden"
                                   class="colorInput" />
                        </div>
                    </td>
                </tr>
                <!--TEXT COLOR-->
                <tr class="ovu-vertical-align ovu-settings-color-picker-row">
                    <td class="ovu-settings-label"><?php _e('Text Color', 'ovu_domain');?></td>
                    <td class="ovu-settings-color-picker">
                        <div id="ovu_settings_text_color">
                            <a class="color" title="<?php _e('Select a text color for the units container.','ovu_domain') ?>">
                                <div id="ovu_inner_text_color" class="colorInner"></div>
                            </a>
                            <div class="track"></div>
                            <ul class="dropdown"><li></li></ul>
                            <input id="hidden-input-text-color"
                                   name="hidden-input-text-color"
                                   type="hidden"
                                   class="colorInput" />
                        </div>
                    </td>
                </tr>
                <!--TOP BORDER COLOR-->
                <tr class="ovu-vertical-align ovu-settings-color-picker-row">
                    <td class="ovu-settings-label"><?php _e('Top Border Color', 'ovu_domain');?></td>
                    <td class="ovu-settings-color-picker">
                        <div id="ovu_settings_top_border_color">
                            <a class="color" title="<?php _e('Select a color for the top border of the units container.','ovu_domain') ?>">
                                <div id="ovu_inner_top_border_color" class="colorInner"></div>
                            </a>
                            <div class="track"></div>
                            <ul class="dropdown"><li></li></ul>
                            <input id="hidden-input-top-border-color"
                                   name="hidden-input-top-border-color"
                                   type="hidden"
                                   class="colorInput" />
                        </div>
                    </td>
                </tr>
                <!--BOTTOM BORDER COLOR-->
                <tr class="ovu-vertical-align ovu-settings-color-picker-row">
                    <td class="ovu-settings-label"><?php _e('Bottom Border Color', 'ovu_domain');?></td>
                    <td class="ovu-settings-color-picker">
                        <div id="ovu_settings_bottom_border_color">
                            <a class="color" title="<?php _e('Select a color for the bottom border of the units container.','ovu_domain') ?>">
                                <div id="ovu_inner_bottom_border_color" class="colorInner"></div>
                            </a>
                            <div class="track"></div>
                            <ul class="dropdown"><li></li></ul>
                            <input id="hidden-input-bottom-border-color"
                                   name="hidden-input-bottom-border-color"
                                   type="hidden"
                                   class="colorInput" />
                                   <!--value="darkorange"/>-->
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--
                A Submit button is not needed because localStorage is used to capture and update all data required
                by this plugin. The HTML is being left here for possible future use. The opening php tags have been
                modified to disable php processing until further needed

                        <p class="button_settings-page--submit">
                            <input id="submit"
                                   name="submit"
                                   type="submit"
                                   class="button button-primary"
                                   value="< php _e('Save Changes','ovu_domain') ?>"
                                   title="< php _e('Save Changes','ovu_domain') ?>">
                        </p>
            -->
		</form>
		
	</div>

<?php
    // ECHO CONTENTS OF THE OUTPUT BUFFER TO THE PAGE
	echo ob_get_clean();
}
add_action('admin_menu', 'ovu_options_menu_link');

// REGISTER SETTINGS
function ovu_register_settings(){
	register_setting('ovu_settings_group','ovu_settings');
}
add_action('admin_init','ovu_register_settings');