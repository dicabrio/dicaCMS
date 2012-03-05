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
				//				template_external_list_url : "lists/template_list.js",
				//				external_link_list_url : "lists/link_list.js",
				//				external_image_list_url : "lists/image_list.js",
				//				media_external_list_url : "lists/media_list.js",
				
				file_browser_callback : myFileBrowser,

				// Replace values for the template plugin
				template_replace_values : {
					username : "Some User",
					staffid : "991234"
				}
			});
		});
	});
	
	
	function myFileBrowser (field_name, url, type, win) {

		// alert("Field_Name: " + field_name + "nURL: " + url + "nType: " + type + "nWin: " + win); // debug/testing

		/* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
       the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
       These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */

		var cmsURL = window.location.toString();    // script URL - use an absolute path!
		if (cmsURL.indexOf("?") < 0) {
			//add the type as the only query parameter
			cmsURL = cmsURL + "?type=" + type;
		}
		else {
			//add the type as an additional query parameter
			// (PHP session ID is now included if there is one at all)
			cmsURL = cmsURL + "&type=" + type;
		}

		tinyMCE.activeEditor.windowManager.open({
			file : cmsURL,
			title : 'My File Browser',
			width : 420,  // Your dimensions may differ - toy around with them!
			height : 400,
			resizable : "yes",
			inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
			close_previous : "no"
		}, {
			window : win,
			input : field_name
		});
		return false;
	}
});