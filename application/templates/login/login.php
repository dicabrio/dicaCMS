<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>login</title>
	</head>
	<body>
		<?php echo $form->begin(); ?>
			<fieldset>
				<legend><?php echo Lang::get('login.legend'); ?></legend>
				<?php if (count($aErrors) > 0) : ?>
					<ul class="error">
					<?php foreach ($aErrors as $sError) : ?>
						<li><?php echo Lang::get('login.'.$sError); ?></li>
					<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<label for="username"><?php echo Lang::get('login.username'); ?>:</label>
				<?php echo $form->getFormElement('username'); ?><br />
				
				<label for="password"><?php echo Lang::get('login.password'); ?>:</label>
				<?php echo $form->getFormElement('password'); ?><br />

				<?php echo $form->getSubmitButton('login'); ?>
			</fieldset>
		<?php echo $form->end(); ?>
	</body>
</html>