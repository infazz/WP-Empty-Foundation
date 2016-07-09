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
							text: 'Button',
							onclick: function() {
								tinymce.activeEditor.execCommand('buttonCMD');
							}
						},
						{
							text: 'Dropcap',
							onclick: function() {
								tinymce.activeEditor.execCommand('dropcapCMD');
								//editor.insertContent('[dropcap cap="1"]Your content goes here.[/dropcap]');
							}
						},
						{
							text: 'Toggle',
							onclick: function() {
								editor.insertContent('[toggle title="Your title goes here"]Your content goes here.[/toggle]');
							}
						},
						{
							text: 'Tabs',
							onclick: function() {
								editor.insertContent('[tabs tab1="Title #1" tab2="Title #2"][tab1] Tab 1 content... [/tab1][tab2] Tab 2 content... [/tab2][/tabs]');
							}
						},
						{
							text: 'Hide on mobile',
							onclick: function() {
                            	selection = tinyMCE.activeEditor.selection.getContent();
								editor.insertContent('[hide_on_mobile]'+selection+'[/hide_on_mobile]');
							}
						},
						{
							text: 'Box',
							onclick: function() {
								editor.insertContent('[box]Your content goes here.[/box]');
							}
						},
						/*
						{
							text: 'Shortcode name',
							onclick: function() {
								editor.insertContent('[people medium="6" large="4"]');
							}
						}
						*/
					]
				},
                {
					text: 'Grid Elements',
					menu: [
						{
							text: 'Clearfix',
							onclick: function() {
								editor.insertContent('[clearfix]Your content here[/clearfix]');
							}
						},
						{
							text: 'Row',
							onclick: function() {
								editor.insertContent('[row]Your content here[/row]');
							}
						},
						{
							text: 'Grid element',
							onclick: function() {
								editor.insertContent('[grid medium="6" large="4" class=""]Your content here[/grid]');
							}
						}
					]
				}
			]
		});
			//editor.insertContent('[name title="Илья Семёнов" subtitle="Руководитель компании «МузКафе»" color="#34aeaf"]');
			editor.addCommand('dropcapCMD', function() {
			    var data = {
			        num: '',
			        heading: '',
			        text: '',
			        class: 'white'
			    };
			    editor.windowManager.open({
			        title: 'Dropcap',
			        data: data,
			        body: [
			            {
			                name: 'num',
			                type: 'textbox',
			                label: 'Number/Character',
			                value: data.num,
			                onchange: function() { data.num = this.value(); }
			            },
			            {
			                name: 'heading',
			                type: 'textbox',
			                'multiline': 'true', 
			                'minHeight': '60',
			                'minWidth': 300,
			                label: 'Title',
			                value: data.heading,
			                onchange: function() { data.heading = this.value(); }
			            },
			            {
			                name: 'text',
			                type: 'textbox',
			                'multiline': 'true', 
			                'minHeight': '120',
			                'minWidth': 300,
			                label: 'Text',
			                value: data.text,
			                onchange: function() { data.text = this.value(); }
			            },
			            {
			                name: 'class',
			                type: 'listbox',
			                label: 'Style',
			                values: [
			                    {
			                        value: 'white',
			                        text: 'White'
			                    },
			                    {
			                        value: 'yellow',
			                        text: 'Yellow'
			                    },
			                    {
			                        value: 'orange',
			                        text: 'Orange'
			                    },
			                    {
			                        value: 'pink',
			                        text: 'Pink'
			                    },
			                    {
			                        value: 'violet',
			                        text: 'Violet'
			                    },
			                    {
			                        value: 'blue',
			                        text: 'Blue'
			                    },
			                    {
			                        value: 'green',
			                        text: 'Green'
			                    },
			                    {
			                        value: 'green_light',
			                        text: 'Light green'
			                    },
			                ],
			                onchange: function() { data.class = this.value(); }
			            }
			        ],
			        onSubmit: function(e) {
			            var shortcode = '[dropcap';
			            data = tinymce.extend(data, e.data);
			 
			            shortcode += ' num="' + data.num + '"';
			            shortcode += ' class="' + data.class + '"';
			            shortcode += ' heading="' + data.heading + '"';
			            shortcode += ' text="' + data.text + '"';
			 
			            shortcode += ']';
			 
			            tinymce.execCommand('mceInsertContent', false, shortcode);
			        }
			    });
			});


			

			editor.addCommand('buttonCMD', function() {
			    var data = {
			        title: '',
			        url: 'http://',
			        class: ''
			    };
			    editor.windowManager.open({
			        title: 'Button',
			        data: data,
			        body: [
			            {
			                name: 'title',
			                type: 'textbox',
			                label: 'Button name',
			                value: data.title,
			                onchange: function() { data.title = this.value(); }
			            },
			            {
			                name: 'url',
			                type: 'textbox',
			                label: 'URL',
			                value: data.url,
			                onchange: function() { data.url = this.value(); }
			            },
			            {
			                name: 'class',
			                type: 'textbox',
			                label: 'Class',
			                value: data.class,
			                onchange: function() { data.class = this.value(); }
			            }
			        ],
			        onSubmit: function(e) {
			            var shortcode = '[button';
			            data = tinymce.extend(data, e.data);
			 
			            shortcode += ' title="' + data.title + '"';
			            shortcode += ' url="' + data.url + '"';
			            shortcode += ' class="' + data.class + '"';
			 
			            shortcode += ']';
			 
			            tinymce.execCommand('mceInsertContent', false, shortcode);
			        }
			    });
			});


	});




})();
