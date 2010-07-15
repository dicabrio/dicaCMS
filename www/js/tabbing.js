/**
 * tabbing system
 */
$(function () {
	$('#tabmenu li a').click(function (e) {
		selectTab(this);
	});
	
	$('#tabmenu li.active a').click();
	var urlHash = window.location.hash;
	selectTab($('#tabmenu li a.'+urlHash.substr(1)));
});

/**
 * selecting the tab. Closes all other tabs
 * @param el
 * @return
 */
function selectTab(el) {
	var sClassName = $(el).attr('className');
	// activate the right tablink
	$('#tabmenu li').removeClass('active');
	$(el).parent().addClass('active');
	
	// activate the right tabpanel
	$('#tabmenu li a').each(function () {
		var sClassName = $(this).attr('className');
		$('#'+sClassName+"tab").hide();
	});
	$('#'+sClassName+"tab").show();
}