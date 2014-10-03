(function() {
	tinymce.PluginManager.add('my_mce_button', function( editor, url ) {
		editor.addButton( 'my_mce_button', {
			text: 'Elements',
			icon: false,
			type: 'menubutton',
			menu: [
				{
					text: 'UI',
					menu: [
						{
							text: 'Toggle',
							onclick: function() {
								editor.insertContent('[toggle title="Your title goes here"]Your content goes here.[/toggle]');
							}
						},
						{
							text: 'Tabs',
							onclick: function() {
								editor.insertContent('[tabs tab1="Title #1" tab2="Title #2"] [tab1] Tab 1 content... [/tab1] [tab2] Tab 2 content... [/tab2] [/tabs]');
							}
						},
						{
							text: 'Bussines card',
							onclick: function() {
								editor.insertContent('[card] Your company info here [/card]');
							}
						},
						{
							text: 'Left content',
							onclick: function() {
								editor.insertContent('[left] Your info here [/left]');
							}
						},
						{
							text: 'Hide on mobile',
							onclick: function() {
                            	selection = tinyMCE.activeEditor.selection.getContent();
								editor.insertContent('[hide_on_mobile]'+selection+'[/hide_on_mobile]');
							}
						}
					]
				},
                {
					text: 'Grid Elements',
					menu: [
                        {
							text: 'Wrap',
							onclick: function() {
								editor.insertContent('[wrap] Your info here [/wrap]');
							}
						},
						{
							text: '25%',
							onclick: function() {
								editor.insertContent('[25] Your info here [/25]');
							}
						},
						{
							text: '33%',
							onclick: function() {
								editor.insertContent('[33] Your info here [/33]');
							}
						},
						{
							text: '50%',
							onclick: function() {
								editor.insertContent('[50] Your info here [/50]');
							}
						}
					]
				}
			]
		});
	});
})();
