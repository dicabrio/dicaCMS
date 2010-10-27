/**
 * tabbing system
 */
var TabSystem = {
	tabs : [],
	actions : {},

	addTab : function (tab) {
		this.tabs.push(tab);
	},
	
	addListener : function (tabname, fn) {

		if(!this.actions[tabname]) {
			this.actions[tabname] = [];
		}

		this.actions[tabname].push(fn);
	},

	enableBehaviour : function () {
		for (var i=0; i < this.tabs.length; i++) {
			this.addClickBehaviour(this.tabs[i]);
		}
	},

	addClickBehaviour : function (tab) {
		var self = this;
		$(tab).click(function (event) {
			// first hide everything
			var className = $(this).attr('className');
			if (self.actions[className]) {
				for (var j = 0; j < self.actions[className].length; j++) {
					self.actions[className][j](tab);
				}
			}
		});
	},

	init : function () {
		var self = this;
		$('#tabmenu li a').each(function () {
			var className = $(this).attr('className');
			self.addTab(this);
			self.addListener(className, function (clickedTabElement) {
				// hide everything
				$('#tabmenu li').removeClass('active'); // deactivate tab menu item
				$('fieldset.tab').hide(); // hide panels

				// show only needed
				$(clickedTabElement).parent().addClass('active');
				$('fieldset#'+className+"tab.tab").show(); // panel
			});
		});

		this.enableBehaviour();
	}
}

