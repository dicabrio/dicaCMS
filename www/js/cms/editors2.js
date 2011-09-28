$(function () {
	
	
	var editorsEnabled = false;
	
	TabSystem.addListener('content', function () {

		if (editorsEnabled == true) {
			return;
		}
		editorsEnabled = true;
		$('.mce-editor textarea.moduletextblock').each(function (i) {
		
			var id = "mce_element_"+i;
			$(this).attr('id', id);
		
			tinyMCE.init({
			
				// General options
				mode : "exact",
				elements : id,
				theme : "advanced",
				plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

				// Theme options
				//theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
				//theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				//theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
				//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
				//theme_advanced_toolbar_location : "top",
				//theme_advanced_toolbar_align : "left",
				//theme_advanced_statusbar_location : "bottom",
				//theme_advanced_resizing : true,
				theme_advanced_buttons1 : ",bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect|,fullscreen",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,link,unlink,anchor,image,cleanup,code,",
				theme_advanced_buttons3 : "",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
//				theme_advanced_statusbar_location : "bottom",
				//theme_advanced_resizing : true,

				// Example content CSS (should be your site CSS)
				content_css : "css/content.css",

				// Drop lists for link/image/media/template dialogs
				template_external_list_url : "lists/template_list.js",
				external_link_list_url : "lists/link_list.js",
				external_image_list_url : "lists/image_list.js",
				media_external_list_url : "lists/media_list.js",

				// Replace values for the template plugin
				template_replace_values : {
					username : "Some User",
					staffid : "991234"
				}
			});
		});
	/*

		var editors = [];

		$('.yui-skin-sam .moduletextblock').each(function () {

			var myEditor = new YAHOO.widget.Editor($(this).attr('id'), {
				height: '200px',
				width: '500px',
				dompath: false, //Turns on the bar at the bottom
				animate: true, //Animates the opening, closing and moving of Editor windows
				toolbar: {
					titlebar: 'editor',
					buttonType: 'advanced',
					buttons: [
						{group: 'textstyle', label: 'Font Style',
							buttons: [
								{type: 'push', label: 'Bold', value: 'bold'},
								{type: 'push', label: 'Italic', value: 'italic'},
								{type: 'push', label: 'Underline', value: 'underline'}
							]
						},
						{group: 'indentlist', label: 'Lists',
							buttons: [
								{type: 'push', label: 'Create an Unordered List', value: 'insertunorderedlist'},
								{type: 'push', label: 'Create an Ordered List', value: 'insertorderedlist'}
							]
						},
						{group: 'insertitem', label: 'Insert Item',
							buttons: [
								{type: 'push', label: 'HTML Link CTRL + SHIFT + L', value: 'createlink', disabled: true},
								{type: 'push', label: 'Insert Image', value: 'insertimage'}
							]
						}
					]
				}
			});
			
			myEditor.render();
			editors.push(myEditor);
		});

		YAHOO.util.Event.on('pageform', 'submit', function() {
			//Put the HTML back into the text area
			for (var i = 0; i < editors.length; i++) {
				editors[i].saveHTML();
			}

			// The var html will now have the contents of the textarea
			// var html = myEditor.get('element').value;
		});*/

	});
});