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

			<?php if (isset($oOverview)) : ?>
			<?php echo $oOverview->getContents(); ?>
			<?php endif; ?>
