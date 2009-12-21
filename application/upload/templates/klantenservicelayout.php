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
			<?php echo $pagemenu_mainmenu; ?>
			<div id="main">
				<div class="left-block">
					<h2><img src="http://dicabrio.com/text.php?text=Contact&color=1" alt="Lounge" /></h2>
					<p><?php echo $textblock_contact; ?></p>
				</div>
				<div class="right-block">
					<h2><img src="http://dicabrio.com/text.php?text=Verzendingen&color=1" alt="Lounge" /></h2>
					<p><?php echo $textblock_verzendingen; ?></p>
				</div>
				<div class="left-block">
					<h2><img src="http://dicabrio.com/text.php?text=Ruilen%20en%20retouren&color=1" alt="Lounge" /></h2>
					<p><?php echo $textblock_ruilenenretouren; ?></p>
				</div>
				<div class="right-block">
					<h2><img src="http://dicabrio.com/text.php?text=FAQ&color=1" alt="Lounge" /></h2>
					<p><?php echo $textblock_FAQ; ?></p>
				</div>
				<div class="left-block">
					<h2><img src="http://dicabrio.com/text.php?text=Algemene%20voorwaarden&color=1" alt="Lounge" /></h2>
					<p><?php echo $textblock_algemenevoorwaarden; ?></p>
				</div>
				<div class="right-block">
					<h2><img src="http://dicabrio.com/text.php?text=voordelen&color=1" alt="Lounge" /></h2>
					<p><?php echo $textblock_voordelen; ?></p>
				</div>
				<div class="clear">&nbsp;</div>
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