			<?php if (isset($oBreadCrumb)) : ?>
			<?php echo $oBreadCrumb->getContents(); ?>
			<?php endif; ?>

			<?php if (isset($actions)) : ?>
			<?php echo $actions->getContents(); ?>
			<?php endif; ?>

			<?php if (isset($aErrors) && count($aErrors) > 0) : ?>
				<?php foreach ($aErrors as $sError) : ?>
					<li><?php echo Lang::get($sError); ?></li>
				<?php endforeach; ?>
			<?php endif; ?>
			
			<form method="post" action="<?php echo $sSearchFormAction; ?>">
			<?php if (isset($oSearch)) : ?>
			<?php echo $oSearch->getContents(); ?>
			<?php endif; ?>
			</form>
			
			<form method="post" action="<?php echo $sShowFormAction;?>">
			<?php if (isset($oOverview)) : ?>
			<?php echo $oOverview->getContents(); ?>
			<?php endif; ?>
			</form>