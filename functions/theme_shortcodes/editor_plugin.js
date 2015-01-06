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
							text: 'Name',
							onclick: function() {
								tinymce.activeEditor.execCommand('nameCMD');
								//editor.insertContent('[name title="Илья Семёнов" subtitle="Руководитель компании «МузКафе»" color="#34aeaf"]');
							}
						},
						{
							text: 'Кнопка',
							onclick: function() {
								tinymce.activeEditor.execCommand('buttonCMD');
								//editor.insertContent('[name title="Илья Семёнов" url="#url" class="red"]');
							}
						},
						{
							text: 'Шаг',
							onclick: function() {
								editor.insertContent('[step num="1"]Текст шага. Макс. количество шагов 3.[/step]');
							}
						},
						{
							text: 'Box',
							onclick: function() {
								editor.insertContent('[box]Your content goes here.[/box]');
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
								editor.insertContent('[tabs tab1="Title #1" tab2="Title #2"] [tab1] Tab 1 content... [/tab1] [tab2] Tab 2 content... [/tab2] [/tabs]');
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
						},
						{
							text: 'Timeline',
							onclick: function() {
								editor.insertContent('[timeline]');
							}
						},
						{
							text: 'People',
							onclick: function() {
								editor.insertContent('[people medium="6" large="4"]');
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
								editor.insertContent('[grid medium="6" large="4"]Your content here[/grid]');
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
			        grid: '6',
			        class: 'white'
			    };
			    editor.windowManager.open({
			        title: 'Dropcap',
			        data: data,
			        body: [
			            {
			                name: 'num',
			                type: 'textbox',
			                label: 'Номер/Буква',
			                value: data.num,
			                onchange: function() { data.num = this.value(); }
			            },
			            {
			                name: 'heading',
			                type: 'textbox',
			                'multiline': 'true', 
			                'minHeight': '60',
			                'minWidth': 300,
			                label: 'Зоголовок',
			                value: data.heading,
			                onchange: function() { data.heading = this.value(); }
			            },
			            {
			                name: 'text',
			                type: 'textbox',
			                'multiline': 'true', 
			                'minHeight': '120',
			                'minWidth': 300,
			                label: 'Текст',
			                value: data.text,
			                onchange: function() { data.text = this.value(); }
			            },
			            {
			                name: 'grid',
			                type: 'listbox',
			                label: 'Стиль',
			                values: [
			                    {
			                        value: '6',
			                        text: '6/12'
			                    },
			                    {
			                        value: '12',
			                        text: '12/12'
			                    },
			                ],
			                onchange: function() { data.grid = this.value(); }
			            },
			            {
			                name: 'class',
			                type: 'listbox',
			                label: 'Стиль',
			                values: [
			                    {
			                        value: 'white',
			                        text: 'Белый'
			                    },
			                    {
			                        value: 'yellow',
			                        text: 'Жёлтый'
			                    },
			                    {
			                        value: 'orange',
			                        text: 'Оранжевый'
			                    },
			                    {
			                        value: 'pink',
			                        text: 'Розовый'
			                    },
			                    {
			                        value: 'violet',
			                        text: 'Фиолетовый'
			                    },
			                    {
			                        value: 'blue',
			                        text: 'Синий'
			                    },
			                    {
			                        value: 'green',
			                        text: 'Зелёная'
			                    },
			                    {
			                        value: 'green_light',
			                        text: 'Ярко зелёная'
			                    },
			                ],
			                onchange: function() { data.class = this.value(); }
			            }
			        ],
			        onSubmit: function(e) {
			            var shortcode = '[dropcap';
			            data = tinymce.extend(data, e.data);
			 
			            shortcode += ' num="' + data.num + '"';
			            shortcode += ' grid="' + data.grid + '"';
			            shortcode += ' class="' + data.class + '"';
			            shortcode += ' heading="' + data.heading + '"';
			            shortcode += ' text="' + data.text + '"';
			 
			            shortcode += ']';
			 
			            tinymce.execCommand('mceInsertContent', false, shortcode);
			        }
			    });
			});


			editor.addCommand('nameCMD', function() {
			    var data = {
			        title: '',
			        subtitle: '',
			        class: 'green'
			    };
			    editor.windowManager.open({
			        title: 'Подпись',
			        data: data,
			        body: [
			            {
			                name: 'title',
			                type: 'textbox',
			                label: 'Имя',
			                value: data.title,
			                onchange: function() { data.title = this.value(); }
			            },
			            {
			                name: 'subtitle',
			                type: 'textbox',
			                label: 'Позиция',
			                value: data.url,
			                onchange: function() { data.subtitle = this.value(); }
			            },
			            {
			                name: 'class',
			                type: 'listbox',
			                label: 'Стиль',
			                values: [
			                    {
			                        value: 'red',
			                        text: 'Красная'
			                    },
			                    {
			                        value: 'green',
			                        text: 'Зелёная'
			                    },
			                    {
			                        value: 'white',
			                        text: 'Белая'
			                    },
			                ],
			                onchange: function() { data.class = this.value(); }
			            }
			        ],
			        onSubmit: function(e) {
			            var shortcode = '[name';
			            data = tinymce.extend(data, e.data);
			 
			            shortcode += ' title="' + data.title + '"';
			            shortcode += ' subtitle="' + data.subtitle + '"';
			            shortcode += ' class="' + data.class + '"';
			 
			            shortcode += ']';
			 
			            tinymce.execCommand('mceInsertContent', false, shortcode);
			        }
			    });
			});

			editor.addCommand('buttonCMD', function() {
			    var data = {
			        title: '',
			        url: 'http://',
			        class: 'red'
			    };
			    editor.windowManager.open({
			        title: 'Кнопка',
			        data: data,
			        body: [
			            {
			                name: 'title',
			                type: 'textbox',
			                label: 'Текст',
			                value: data.title,
			                onchange: function() { data.title = this.value(); }
			            },
			            {
			                name: 'url',
			                type: 'textbox',
			                label: 'Ссылка',
			                value: data.url,
			                onchange: function() { data.url = this.value(); }
			            },
			            {
			                name: 'class',
			                type: 'listbox',
			                label: 'Стиль',
			                values: [
			                    {
			                        value: 'red',
			                        text: 'Красная'
			                    },
			                    {
			                        value: 'green',
			                        text: 'Зелёная'
			                    },
			                    {
			                        value: 'white',
			                        text: 'Белая'
			                    },
			                    {
			                        value: 'guru',
			                        text: 'Аудиогуру'
			                    },
			                    {
			                        value: 'guru2',
			                        text: 'Аудиогуру 2'
			                    },
			                ],
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
