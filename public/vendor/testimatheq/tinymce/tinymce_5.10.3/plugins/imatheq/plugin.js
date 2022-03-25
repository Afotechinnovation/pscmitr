
tinymce.PluginManager.add('imatheq', function(editor, url) {

	//load common js
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url + "/common/common.js";
    document.getElementsByTagName('head')[0].appendChild(script);
	
	var languages = ['en','zh_cn','nn','de','fr','fi','nl','sv','pl','it','es','tr','da','pt','lv']
	var lang = tinymce.activeEditor.settings.language;
	if(lang !== null && lang !== undefined) {
		lang = lang.toLowerCase();
		if(languages.indexOf(lang) == -1) {
			lang = lang.split("_")[0];
			if(languages.indexOf(lang) == -1) {
				lang = null;
			}
		}
	}
	if(lang === null || lang === undefined) {
		lang = "en";
	}

	//load language file
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url + "/languages/" + lang + "/strings.js";
    document.getElementsByTagName('head')[0].appendChild(script);
	
	function _imatheq_openEditor(lang, is_iframe, mml) {
		if(_imatheq_plugin_loaded !== null && _imatheq_plugin_loaded !== undefined 
				&& _imatheq_plugin_loaded()) {
			imatheq_openEditor(null, lang, is_iframe, mml,
				// Callback
				function (values) {
					// Insert the contents of the iMathEQ editor into the editor
					editor.insertContent("<img imatheq-mml=\"" + values.mathml + "\" src=\"" + 
						values.base64Img + "\" alt=\"" + values.alt + "\">",
							{merge:true, paste:true});
			})
		} else {
			setTimeout(_imatheq_openEditor(lang, is_iframe, mml), 200);
		}
	}

	function showMathEditor(dblclick) {
		var win, data = {}, dom = editor.dom, imgElm, figureElm;
		var width, height, imageListCtrl, classListCtrl, imageDimensions = editor.settings.image_dimensions !== false;

		imgElm = editor.selection.getNode();

		if(hasSelection(editor)) {
			if (imgElm !== null && (imgElm.nodeName != 'IMG' || imgElm.getAttribute('data-mce-object') || imgElm.getAttribute('data-mce-placeholder')
					|| (imgElm.nodeName == 'IMG' && dom.getAttrib(imgElm, 'imatheq-mml') == ""))) {	//not iMathEQ object
				if(dblclick) {
					return true;
				}
				imgElm = null;
			}
		} else {
			if(dblclick) {
				return true;
			}
			imgElm = null;
		}
		
		var mml = "";
		if (imgElm) {
			mml = dom.getAttrib(imgElm, 'imatheq-mml');
			if(mml != "") {
				mml = decodeURIComponent(mml);
			}
		}

		var clientWin = editor.dom.getViewPort();

		// Open window
		_imatheq_openEditor(lang, false, mml);

	}
	
	function hasSelection(editor) {
		return (editor.selection.getContent() != "");
	}

	var onInit = function (editor) {
		editor.on('dblclick', function(e) {
			var realEvent = (event) ? event : window.event;
			//var element = realEvent.srcElement ? realEvent.srcElement : realEvent.target;
			showMathEditor(true);
		});
	}		

	if ('onInit' in editor) {
		editor.onInit.add(onInit);
	}
	else {
		editor.on('init', function () {
			onInit(editor);
		});
	}

	function efmase_addEvent(element, event, func) {
		if (element.addEventListener) {
			element.addEventListener(event, func, true);
		}
		else if (element.attachEvent) {
			element.attachEvent('on' + event, func);
		}
	}

	
	if(tinymce.majorVersion < 5) {
		editor.addButton('imatheq', {
			title: 'iMathEQ',
			image: url + '/img/imatheq.png',
			onclick: function() {
				showMathEditor();
			},
			onPostRender: function() {
				var ctrl = this;

				editor.on('NodeChange', function(e) {
					ctrl.active(e.element && e.element.nodeName == 'IMG' && e.element.getAttribute("imatheq-mml") !== null);
				});
			}
		});
	} else {
		editor.ui.registry.addIcon('imatheq', 
			'<svg width="24" height="24" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"'+
				' viewBox="0 0 72 72" enable-background="new 0 0 72 72" xml:space="preserve">'+
			'<path d="M17,64.1c-0.7-0.2-1.1-0.5-1.1-1.1c0-0.3,0.1-0.6,0.4-0.8L37.8,40L16.3,12.2C16,11.9,16,11.9,16,11.6v-1.2'+
				' c0.1-0.5,0.5-0.9,1.1-1h50.5l2.4,18.7h-3c-1-7.5-3.6-11.6-7.5-13.5c-2-0.9-4.1-1.5-6.5-1.7c-2.4-0.2-5.7-0.3-10.1-0.3H26.6L44.8,36'+
				' c0.2,0.2,0.2,0.5,0.2,0.7c0,0.4-0.1,0.6-0.2,0.8L22.9,59.9h19.7c4.4,0,7.8-0.1,10.2-0.4c2.5-0.2,4.6-0.8,6.6-1.7'+
				' c3.9-1.9,6.4-6,7.3-13.5h3l-2.4,19.7H17z"/>'+
			'<path d="M17.8,21.8c0,1.8-1.8,3.2-3.2,3.2c-1.4,0-2.3-1-2.3-2.2c0-1.6,1.6-3.2,3.3-3.2C17,19.6,17.8,20.6,17.8,21.8L17.8,21.8z'+
				' M10.9,50.6c-1.4,3.6-1.7,4.5-1.7,6c0,1.4,0.4,2,1.4,2c3.1,0,5-3.6,6.1-7.4c0.3-0.9,0.3-1.1,0.9-1.1c0.2,0,0.7,0,0.7,0.6'+
				' c0,0.6-2.2,9.3-7.9,9.3c-2.9,0-4.9-2.1-4.9-4.9c0-1.2,0.8-3.3,1.4-4.8c0.9-2.6,3.7-9.6,4.1-11.1c0.2-0.6,0.7-1.9,0.7-3.1'+
				' c0-1.9-1-1.9-1.5-1.9c-2.1,0-4.4,1.8-6.1,7.4c-0.3,1-0.4,1.1-1,1.1c-0.1,0-0.7,0-0.7-0.6c0-0.6,2.3-9.2,7.9-9.2c3,0,4.9,2.2,4.9,4.9'+
				' c0,1.1-0.3,2-0.8,3.2c-0.6,1.6-0.6,1.8-1.3,3.5L10.9,50.6z"/></svg>');
		editor.ui.registry.addToggleButton('imatheq', {
			icon: 'imatheq',
			tooltip: 'iMathEQ',
			onAction: function() {
				showMathEditor();
			},
			onSetup: function(api) {
			  function nodeChangeHandler(){
				const selectedNode = editor.selection.getNode();
				api.setActive(selectedNode && selectedNode.localName == "img" && selectedNode.getAttribute("imatheq-mml") !== null);
			  }
			  editor.on('NodeChange', nodeChangeHandler);
			}
			
		});
	}
	
});