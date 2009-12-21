<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $textLine_titel; ?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="<?php echo $textblock_keywords; ?>" />
		<meta name="description" content="<?php echo $textblock_description; ?>" />
		<?php echo $stylesheet_screenstyle; ?>
		<script type="text/javascript" src="<?php echo Conf::get('general.url.js'); ?>/jquery.js"></script>
		<script type="text/javascript" src="<?php echo Conf::get('general.url.js'); ?>/shop.js"></script>
	</head>
	<body>
		<div id="background">
			<div id="wrapper">
				<div id="header">
					<img src="images/logo-mysensuality.gif" alt="My Sensuality" />
					<img src="images/pinup.gif" alt="pinup" id="pinup" />
				</div>
				<?php echo $pagemenu_mainmenu; ?>
				<div id="main">
					<div id="shop">
						<?php echo $shopmenu_shopmenu; ?>
						<div id="betaalmogelijkheden">
							<h2><img src="http://dicabrio.com/text.php?text=Betaalmogelijkheden&color=1&size=18" alt="Betaalmogelijkheden" /></h2>
							<?php echo $textblock_betaalmogelijkheden; ?>
						</div>
					</div>
					<div id="products">
						<?php echo $shopoverview_overview; ?>
					</div>

					<div class="clear"></div>

					<div class="left-block">
						<img src="images/vipcard.gif" alt="vipcard" class="blockimage" />
						<h2><img src="http://dicabrio.com/text.php?text=VIP%20Account&color=1" alt="VIP Account" /></h2>
						<p>
							<?php echo $textblock_vipaccount; ?>
						</p>
						<span class="button"><a href="#">Aanmaken</a></span>
						<img src="images/attention-vip.gif" alt="Voordelig" class="small-attention" />
					</div>
					<div class="right-block">
						<h2><img src="http://dicabrio.com/text.php?text=Mama%20Cash&color=1" alt="Mama Cash" /></h2>
						<p>
							<?php echo $textblock_mamacash; ?>
						</p>
					</div>
					<div class="clear"></div>
				</div>
				<div id="footer">
					<ul>
						<li><a href="/disclaimer.php">Disclaimer</a></li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>