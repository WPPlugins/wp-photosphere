(function() {
	tinymce.create('tinymce.plugins.wpPhotosphere_ShowButton', {

		init : function(ed, url){
			ed.addButton('wpPhotosphere_Button', {
			title : 'Photosphere',
				onclick : function() {
					ed.execCommand(
						'mceInsertContent',
						false,
						wpPhotosphere_ButtonF()
					);
				},
				image: url + "/btn.png"
			});			
		}
		
	});

	tinymce.PluginManager.add('wpPhotosphere', tinymce.plugins.wpPhotosphere_ShowButton);
})();

function wpPhotosphere_ButtonF() {
	return "[photosphere]"+tinyMCE.activeEditor.selection.getContent()+"[/photosphere]";
}