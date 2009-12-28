/**
 * confirmation on a link action
 */
$(function () {
	$('a[confirm]').click(function (e) {
		if (!confirm($(this).attr('confirm'))) {
			e.preventDefault();
		}
	});
});
