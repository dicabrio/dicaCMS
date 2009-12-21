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
					<img src="<?php echo Conf::get('general.url.www'); ?>/images/logo-mysensuality.gif" alt="My Sensuality" />
					<img src="<?php echo Conf::get('general.url.www'); ?>/images/pinup.gif" alt="pinup" id="pinup" />
				</div>
				<?php echo $pagemenu_mainmenu; ?>
				<div id="main">
					<div id="centralblock">
						<h1><img src="http://dicabrio.com/text.php?text=<?php echo urlencode($textline_titel); ?>&color=1" alt="<?php echo $textline_titel; ?>" /></h1>
						<?php echo $textblock_info; ?>
					</div>
				</div>
				<div id="footer">
					<?php echo $pagemenu_footermenu; ?>
				</div>
			</div>
		</div>
	</body>
</html>