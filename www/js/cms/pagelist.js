/* 
    Document   : pagelist
    Created on : 28-mei-2011, 12:45:40
    Author     : robertcabri
    Description:
        
*/
(function ($) {
	
	$.fn.pageList = function (settings) {
		
		var config = {};
		if (settings) $.extend(config, settings); 
		
		this.each(function (i) {
			var $self = $(this),
			$selectedPagesInput = $self.find('input'),
			$pagesToSelectRow = $self.find('.row'),
			$placeHolder = $self.find('.placeholder'),
			initialSelectedPages = $selectedPagesInput.attr('value').split(',');
			
			for (var i = 0; i < initialSelectedPages.length; i++) {
				_addRow(initialSelectedPages[i]);
			}
			
			$self.find('select')
			.live('change', function (e) {
				_updateSelectedPages();
			})
			
			$self.find('.sub')
			.live('click', function (e) {
				
				e.preventDefault();
				$(this).closest('.row').remove();
				$placeHolder.find('.row:last a.add').removeClass('hide');
				
				if ($placeHolder.find('.row').length == 1) {
					$placeHolder.find('.row a.sub').addClass('hide');
				}
				
				_updateSelectedPages();
			})
			
			function _updateSelectedPages () {
				var selectedPages = [];
				$('select', $self).each(function () {
					if (this.value != 0) {
						selectedPages.push(this.value);
					}
				});
				
				$selectedPagesInput.attr('value', selectedPages.join(','));
			}
			
			function _addRow(selectIndex) {
				var $rowClone = $pagesToSelectRow.clone();
				$placeHolder.find('.row a.add').addClass('hide');
				$placeHolder.append($rowClone);
				
				$('select', $rowClone).val(selectIndex);
				
				if ($placeHolder.find('.row').length > 1) {
					$placeHolder.find('.row a.sub').removeClass('hide');
				}
				
				$rowClone.find('.add')
				.bind('click', function (e) {
					e.preventDefault();
					_addRow();
				});
			}

		});
	}
	
	
})(jQuery)

$(function () {
	
	$('.pagelist').pageList();
	
});