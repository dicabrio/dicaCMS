<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $textLine_titel; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="<?php echo $textblock_keywords; ?>" />
	<meta name="description" content="<?php echo $textblock_description; ?>" />
	<?php echo $stylesheet_screenstyle; ?>
</head>
<body>
	<div id="background">
		<div id="wrapper">
			<div id="header">
				<img src="images/logo-mysensuality.gif" alt="My Sensuality" />
				<img src="images/pinup.gif" alt="pinup" id="pinup" />
			</div>
			<div id="attention">
				<img src="images/attention.gif" alt="Pakketje" />
				<h1><?php echo $textline_kop; ?></h1>
				<p><?php echo $textblock_teaser; ?></p>
			</div>
			<?php echo $pagemenu_mainmenu; ?>
			<div id="main">
				<div class="left-block">
					<h2><img src="http://dicabrio.com/text.php?text=Lounge&color=1" alt="Lounge" /></h2>
					<p><?php echo $textblock_lounge; ?></p>
				</div>
				<div class="right-block">
					<?php echo $productaction_eersteactie; ?>
				</div>
				<div class="left-block">
					<?php echo $productaction_tweedeactie; ?>
				</div>
				<div class="right-block">
					<img src="images/vipcard.gif" alt="vipcard" class="blockimage" />
					<h2><img src="http://dicabrio.com/text.php?text=VIP%20Account&color=1" alt="VIP Account" /></h2>
					<p><?php echo $textblock_vipaccount; ?></p>
					<span class="button"><a href="<?php echo Conf::get('general.url.www'); ?>/mijn-account.php">Aanmaken</a></span>
				</div>
				<div class="left-block">
					<img src="upload/logo-mamacash.gif" alt="Mama Cash" class="mama-cash-small" />
					<h2><img src="http://dicabrio.com/text.php?text=Mama%20Cash&color=1" alt="Mama Cash" /></h2>
					<p><?php echo $textblock_mamacash; ?></p>
				</div>
				<div class="right-block">
					<a name="anchornieuwsbrief"></a>
					<h2><img src="http://dicabrio.com/text.php?text=Nieuwsbrief&color=1" alt="Nieuwsbrief" /></h2>
					<p><?php echo $textblock_nieuwsbrief; ?></p>

					<?php echo $nieuwsbrief_add; ?>

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