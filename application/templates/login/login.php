<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>login</title>
	</head>
	<body>
		<form action="<?php echo $sFormAction; ?>/login/" method="post" name="login">
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
				<input type="text" name="username" value="<?php echo $sUsername; ?>" /><br />
				
				<label for="password"><?php echo Lang::get('login.password'); ?>:</label>
				<input type="password" name="password" /><br />
				
				<input type="submit" name="submit" value="<?php echo Lang::get('login.button'); ?>" />
			</fieldset>

		</form>
	</body>
</html>