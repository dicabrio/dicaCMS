$(function () {
	TabSystem.init();

	var urlHash = window.location.hash;
	if (urlHash) {
		$('#tabmenu li a.'+urlHash.substr(1)).trigger('click');
	} else {
		$('#tabmenu li.active a').trigger('click');
	}
})