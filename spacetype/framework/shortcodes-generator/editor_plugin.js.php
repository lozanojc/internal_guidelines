<?php
	require_once('../../../../../wp-load.php');
	require_once('../../../../../wp-admin/includes/admin.php');
	do_action('admin_init');
	
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');
	
	if(!isset($shortcodesES))
		$shortcodesES = new ShortcodesEditorSelector();

	global $shortcodes_array;

header("Content-type: application/x-javascript");
?>
(function() {
	//******* Load plugin specific language pack
	//tinymce.PluginManager.requireLangPack('example');

	tinymce.create('tinymce.plugins.<?php echo $shortcodesES->buttonName; ?>', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(editor, url) {

			editor.addButton('<?php echo $shortcodesES->buttonName; ?>', {
				type: 'listbox',
				text: 'Shortcodes',
				icon: false,
				classes: 'widget btn menubtn fixed-width listbox',
				onselect: function(e) {
					editor.insertContent(this.value());
				},
				menu: [
					<?php if ($shortcodes_array) : foreach ($shortcodes_array as $name => $value) : ?>
						{text: '<?php echo $name;?>', value: '<?php echo $value;?>'},
					<?php endforeach; endif; ?>
				],
				onPostRender: function() {
					// Select the second item by default
				}
			});


		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Shortcode selector',
				author : 'marquex',
				authorurl : 'http://marquex.es',
				infourl : 'http://marquex.es/387/adding-a-select-box-to-wordpress-tinymce-editor',
				version : "0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('<?php echo $shortcodesES->buttonName; ?>', tinymce.plugins.<?php echo $shortcodesES->buttonName; ?>);
})();
