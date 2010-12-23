$(function () {

	TabSystem.init();
	
	
	var editorsEnabled = false;
	
	TabSystem.addListener('content', function () {

		if (editorsEnabled == true) {
			return;
		}
		editorsEnabled = true;

		var editors = [];

		$('.moduletextblock').each(function () {

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
		});

	});

	var urlHash = window.location.hash;
	if (urlHash) {
		$('#tabmenu li a.'+urlHash.substr(1)).click();
	} else {
		$('#tabmenu li.active a').click();
	}
});