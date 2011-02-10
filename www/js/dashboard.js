
$(function () {
	TabSystem.init();

	var urlHash = window.location.hash;
	if (urlHash) {
		$('#tabmenu li a.'+urlHash.substr(1)).click();
	} else {
		$('#tabmenu li.active a').click();
	}
})
