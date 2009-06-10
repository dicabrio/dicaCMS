/**
 * Distill - eventhandling : http://www.jdistill.com
 * Created by Robert Cabri, Gabor de Mooij
 * thanks to Bryan Price
 * requires the jQuery library : http://www.jquery.com
 */

(function($) {
	var EventClasses	= {}
	,	EventNames		= {};
	
	function makeDispatcher(eventName)
	{
		return function(evt)
		{	var element =	evt.target || evt.srcElement
			,	tmp		=	$(element).attr('class')
			,	classes =	tmp ? tmp.split(' ') : [];
			while (classes.length)
				( tmp=EventClasses[classes.shift()]) &&
				( tmp=tmp[eventName]) &&
				( tmp.apply(element, arguments));
		}
	}
	
	//$.extend({addClassEvents: function (className, events)
	$.extend({distill: function (className, events) {
				for ( var eventName in events )
				{
					if (!EventNames[eventName]) 
					{
						EventNames[eventName] = 1;
						$('body').bind(eventName, makeDispatcher(eventName));
					}
					EventClasses[className] = events;
				}
			}});
})(jQuery);
