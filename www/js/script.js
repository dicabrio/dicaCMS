/* Author: 
	Robert Cabri
 */

var __SITEROOT__ = 'http://test.robertcabri.nl/socialatlas/www/';
//var __SITEROOT__ = 'http://socialatlas.eu/';
$(function () {

	var Links = document.getElementsByTagName( 'A' );

	for( var i = 0; i < Links.length; i++ ) {
		if (Links[i].className.indexOf('external') !== -1) {
			Links[i].onclick = function() {
				var FakeLinkWindow = window.open( this.href, 'target', '' );
				return false;
			}
		}
	}

	$('.default').each(function () {


		var labelForItem = $(this).attr('for');
		var defaultVal = $(this).html();
		var elID = '#'+labelForItem;

		if ($(elID).attr('value') == "") {
			$(elID).attr('value', defaultVal).addClass('defaultvalue').bind('focus click',function () {
				if (this.value == defaultVal) {
					$(this).attr('value', "").toggleClass('defaultvalue');
				}
			}).bind('blur', function () {
				if (this.value == "") {
					$(this).attr('value', defaultVal).toggleClass('defaultvalue');
				}
			});
		}

		$('#form').submit(function () {
			if ($(elID).attr('value') == defaultVal && $(elID).hasClass('defaultvalue')) {
				$(elID).attr('value', "");
			}
		});


		$(this).remove();
	});

	if ($('#comments').length > 0) {
		var skin = {};
		skin['BORDER_COLOR'] = '#8f9fbe';
		skin['ENDCAP_BG_COLOR'] = '#edf0f5';
		skin['ENDCAP_TEXT_COLOR'] = '#333333';
		skin['ENDCAP_LINK_COLOR'] = '#0000cc';
		skin['ALTERNATE_BG_COLOR'] = '#ffffff';
		skin['CONTENT_BG_COLOR'] = '#ffffff';
		skin['CONTENT_LINK_COLOR'] = '#203f7d';
		skin['CONTENT_TEXT_COLOR'] = '#333333';
		skin['CONTENT_SECONDARY_LINK_COLOR'] = '#7777cc';
		skin['CONTENT_SECONDARY_TEXT_COLOR'] = '#666666';
		skin['CONTENT_HEADLINE_COLOR'] = '#333333';
		skin['DEFAULT_COMMENT_TEXT'] = 'Add your comment';
		skin['HEADER_TEXT'] = 'Comments';
		skin['POSTS_PER_PAGE'] = '10';
		google.friendconnect.container.setParentUrl('/' /* location of rpc_relay.html and canvas.html */);
		google.friendconnect.container.renderWallGadget(
		{
			id: 'comments',
			site: '00641881150130250232',
			'view-params':{
				"disableMinMax":"true",
				"scope":"PAGE",
				"allowAnonymousPost":"true",
				"features":"video,comment",
				"startMaximized":"true"
			}
		},
		skin);
	}


	$('#refresh').click(function (e) {
		e.preventDefault();
		// give a new question

		$('#q_placeholder').hide('slow');
		$('#q_placeholder').load(__SITEROOT__+'questionnaire/randomquestion/', function () {
			$('#q_placeholder').show('slow');
		});

	});

	// single question on every page
	$('.submitquestion').live('click', function (e) {
//	$('#q_placeholder .submitquestion').live('click', function (e) {
		e.preventDefault();

		var $submitBtn = $(this);
		var $fieldset = $submitBtn.closest('fieldset');

		var values = [];
//		var openQuestion = $('#q_placeholder .openquestion').attr('value');
		var openQuestion = $fieldset.find('.openquestion').attr('value');
		var context = openQuestion;

		
		if ($fieldset.find('.openquestion').length == 1 && openQuestion == '' && !$fieldset.find('.options input:checked').length) {
			alert('You haven\'t entered an answer');
			return;
		} else if ($fieldset.find('.openquestion').length == 0 && !$fieldset.find('.options input:checked').length) {
			alert('Nothing selected');
			return;
		}
		// submit to server


		if ($fieldset.find('.openquestion').length == 1) {
			values.push('f');
		}
		
		$fieldset.find('.options input:checked').each(function () {
			var v = $(this).attr('value');
			values.push(v);
		});

		$.post(__SITEROOT__+'/questionnaire/answerquestion', {
			'question_id' : $fieldset.find('.question_id').attr('value'),
			'values' : values,
			'context' : context,
			'country' : $fieldset.find('.country').attr('value')
			
		}, function (data) {

			if (data['result'] && data['result'] == '1') {
				$fieldset.hide('slow');

				if ($('#morequestionplaceholder').length > 0) {
					return;
				}

				$fieldset.load(__SITEROOT__+'questionnaire/randomquestion/', function () {
					$fieldset.show('slow');
				});
			}
		},'json');
	});
	
	var chooserLoaded = null;
	$('#choosecountry').toggle(function (e) {
		//	$('#choosecountry').live('click', function (e) {
		e.preventDefault();
		if (chooserLoaded == null) {
			chooserLoaded = 1;
			$('#countrychooser').load(__SITEROOT__+'questionnaire/countrychooser/', function () {});
		}

		$('#countrychooser').show();
	}, function (e) {
		e.preventDefault();

		$('#countrychooser').hide();
	});

	$('#countrychooser a').live('click', function (e) {
		e.preventDefault();
		var href = $(this).attr('href').split('|');
		$('#country').attr('value', href[0]);
		$('#flag').attr('src', 'http://europa.eu/abc/european_countries/images/flags/'+href[1]+'.gif');

		$('#countrychooser').hide();
	})

	// init
	$('#q_placeholder').hide('slow');
	$('#q_placeholder').load(__SITEROOT__+'questionnaire/randomquestion/', function () {
		$('#q_placeholder').show('slow');
	});

	$('#social .embedBtn').toggle(function (e) {
		e.preventDefault();
		$('#embed textarea').attr('value', trim($('#resultingimage').html()));
		$('#embed').show();
	}, function (e) {
		e.preventDefault();
		$('#embed').hide();
	});

	$('#social .likeBtn').toggle(function (e) {
		e.preventDefault();
		$('#facebook').show();
	}, function (e) {
		e.preventDefault();
		$('#facebook').hide();
	});

	$('#morequestionplaceholder').load(__SITEROOT__+'/questionnaire/gimmemorequestions/');


});

function trim(text) {
	return text.replace( /^\s*|\s*$/g, '' );
}


function twitterSearchCallback(twitterResult) {
	var statusHTML = [];
	for (var i = 0; i < twitterResult.results.length; i++){
		var username = twitterResult.results[i].from_user;
		var status = twitterResult.results[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
			return '<a href="'+url+'">'+url+'</a>';
		}).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
			return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
		});

		var tweet = ['<li>',
		'<img src="'+twitterResult.results[i].profile_image_url+'" alt="'+username+'" width="30">',
		//		'<img src="images/test-twitter-avatar.png" alt="'+username+'">',
		'<p>',
		'<a href="http://www.twitter.com/'+username+'">'+username+'</a> '+status,
		'</p>',
		'</li>'];

		statusHTML.push(tweet.join(''));
	}
	$(function () {
		$('#tweets').html(statusHTML.join(''));
	});
}


/*
 * @param time_value
 */
function relative_time(time_value) {

	search = false;
	if (time_value.indexOf(',')) {
		search = true;
	}

	time_value = time_value.split(',').join('');
	var values = time_value.split(" ");

	if (search == false || search == null) {
		//Dec 18, 2010 16:07:59
		time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
	} else {
		//25 Dec, +0000 2010
		//Sat, 25 Dec 2010 13:09:06 +0000
		time_value = values[1] + " " + values[2] + ", " + values[3] + " " + values[4];
	}

	var parsed_date = Date.parse(time_value);
	var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
	var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
	delta = delta + (relative_to.getTimezoneOffset() * 60);

	if (delta < 60) {
		return 'less than a minute ago';
	} else if(delta < 120) {
		return 'about a minute ago';
	} else if(delta < (60*60)) {
		return (parseInt(delta / 60)).toString() + ' minutes ago';
	} else if(delta < (120*60)) {
		return 'about an hour ago';
	} else if(delta < (24*60*60)) {
		return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
	} else if(delta < (48*60*60)) {
		return '1 day ago';
	} else {
		return (parseInt(delta / 86400)).toString() + ' days ago';
	}
}