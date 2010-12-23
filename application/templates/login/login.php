<?php $borderrad = 5; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>login</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style>

			* {
				font-family:sans-serif;
				font-size: 12px;
				padding: 0;
				margin: 0;
			}

			html {
				height: 100%;
			}

			input[type='text'], input[type='password'] {

				border: 1px solid rgba(54,97,93,0.5);
				background-color: rgba(54, 97, 93, 0.10);
				width: 145px;
				padding: 3px 5px;
				margin: 0 0 5px 0;
			}

			input[type='submit'] {
				border: 1px solid rgba(54,97,93,0.5);
				padding: 5px 15px;
				-moz-border-radius: <?php echo $borderrad; ?>px;
				-webkit-border-radius: <?php echo $borderrad; ?>px;
				-opera-border-radius: <?php echo $borderrad; ?>px;
				-khtml-border-radius: <?php echo $borderrad; ?>px;
				border-radius: <?php echo $borderrad; ?>px;
				background-image: -moz-linear-gradient(top, #efefef, #b9b9b9);
				background-image: -webkit-gradient(linear,
					left bottom,
					left top,
					color-stop(1.00, #efefef),
					color-stop(0.00, #b9b9b9)
					);
				text-shadow: rgba(255,255,255,1) 0px 1px 0px;
				cursor: pointer;
			}

			body {
				background-image: -moz-linear-gradient(top, rgb(54,97,93), rgb(52,168,161));
				background-image: -webkit-gradient(linear,
					left bottom,
					left top,
					color-stop(1.00, rgb(54,97,93)),
					color-stop(0.00, rgb(52,168,161))
					);
				background-color: rgb(54,97,93);
				background-repeat: no-repeat;
				height: 100%;

			}

			#login {
				height: 100%;
				width: 100%;
			}

			#login #loginpanel {
				width: 300px;
				margin: 0 auto;
				background: #fff;
				padding: 25px 30px 33px 30px;
				box-shadow: 10px 10px 5px #000;
				-moz-box-shadow: 0 0 1em #000;
				-webkit-box-shadow: 0 0 1em #000;
			}

			#loginpanel fieldset {
				border: 1px solid rgba(54,97,93,0.3);
				padding: 5px 10px 10px 10px;
			}

			#loginpanel fieldset legend {
				padding: 0px 5px;
				font-weight: bold;
				font-size: 13px;
			}

			.error {
				background-color: red;
				color: #fff;
				padding: 5px 10px 5px 25px;
				margin: 0 0 10px 0;
			}

			#loginpanel table {
				width: 100%;
				margin: 5px;
			}
		</style>
	</head>
	<body>
		<table id="login">
			<tr>
				<td>
					<div id="loginpanel">
						<?php echo $form->begin(); ?>
						<fieldset>
							<legend>dicaCMS <?php echo Lang::get('login.legend'); ?></legend>
							<?php if (count($errors) > 0) : ?>
							<ul class="error">
									<?php foreach ($errors as $error) : ?>
								<li><?php echo Lang::get('login.'.$error); ?></li>
									<?php endforeach; ?>
							</ul>
							<?php endif; ?>

							<table>
								<tr>
									<td>
										<label for="username"><?php echo Lang::get('login.username'); ?>:</label>

									</td>
									<td>
										<?php echo $form->getFormElement('username'); ?><br />

									</td>
								</tr>
								<tr>
									<td>
										<label for="password"><?php echo Lang::get('login.password'); ?>:</label>

									</td>
									<td>
										<?php echo $form->getFormElement('password'); ?><br />

									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<?php echo $form->getFormElement('login'); ?>

									</td>
								</tr>
							</table>
						</fieldset>
						<?php echo $form->end(); ?>
					</div>
				</td>
			</tr>
		</table>
	</body>
</html>
