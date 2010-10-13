<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
        "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $sTitle; ?></title>
		<meta http-equiv="Content-Type" content="text/xhtml; charset=UTF-8" />
		<link rel="stylesheet" href="<?php echo Conf::get('general.url.css'); ?>/style.css" media="screen" />
		<?php if (isset($aScripts)) : ?>
			<?php foreach ($aScripts as $sScript) : ?>
				<script type="text/javascript" src="<?php echo Conf::get('general.url.js');  ?>/<?php echo $sScript; ?>"></script>
			<?php endforeach; ?>
		<?php endif; ?>
	</head>
	<body>
		<div id="header">
			<h1>dicaCMS</h1>
			<?php echo $oMainMenu->getContents(); ?>
		</div>
		<div id="modmod">
			<div id="modules">
				<?php echo $oSubMenu->getContents(); ?>
			</div>
		
			<div id="main">
				<?php if (isset($oModule)) : ?>
				<?php echo $oModule->getContents(); ?>
				<?php endif; ?>			
			</div>
		</div>	
		<div id="footer">&copy; dicaCMS</div>
	</body>
</html>
