<?php 

	$this->addStyle('http://yui.yahooapis.com/2.8.1/build/assets/skins/sam/skin.css');
	$this->addStyle(Conf::get('general.url.css').'/editors.css');
	
	$this->addScript('http://yui.yahooapis.com/2.8.1/build/yahoo-dom-event/yahoo-dom-event.js');
	$this->addScript('http://yui.yahooapis.com/2.8.1/build/element/element-min.js');
	$this->addScript('http://yui.yahooapis.com/2.8.1/build/container/container_core-min.js');
	$this->addScript('http://yui.yahooapis.com/2.8.1/build/menu/menu-min.js');
	$this->addScript('http://yui.yahooapis.com/2.8.1/build/editor/editor-min.js');
	
	$this->addScript(Conf::get('general.url.js').'/tabbing.js');
	$this->addScript(Conf::get('general.url.js').'/editors.js');

?>
<?php if (isset($breadcrumb)) : ?>
	<?php echo $breadcrumb->getContents(); ?>
<?php endif; ?>
<ul id="tabmenu">
	<?php if (count($aModules) == 0) : ?>
	<li class="active"><a href="#pageinfo" class="pageinfo"><?php echo Lang::get('page.tab.pageinfo'); ?></a></li>
	<?php else : ?>
	<li class="active"><a href="#content" class="content"><?php echo Lang::get('page.tab.content'); ?></a></li>
	<li><a href="#pageinfo" class="pageinfo"><?php echo Lang::get('page.tab.pageinfo'); ?></a></li>
	<?php endif; ?>
	<!--<li><a href="#access" class="access"><?php echo Lang::get('page.tab.access'); ?></a></li>-->
</ul>
<?php echo $form->begin(); ?>

<?php if (count($aErrors) > 0) : ?>
<ul class="error">
		<?php foreach ($aErrors as $key => $sError) : ?>
	<li><?php echo Lang::get('page.'.$sError); ?> (<?php echo $key; ?>)</li>
		<?php endforeach; ?>
</ul>
<?php endif; ?>

<fieldset class="tab" id="pageinfotab">
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('page.label.pagename'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('page_id'); ?>
			<?php echo $form->getFormElement('pagename'); ?> <?php echo Lang::get('page.pagenameexample'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('page.label.template'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('template_id'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('page.label.publishtime'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('publishtime'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('page.label.expiretime'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('expiretime'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('page.label.title'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('title'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('page.label.keywords'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('keywords'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('page.label.description'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('description'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('page.label.redirect'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('redirect'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('page.label.active'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('active'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
</fieldset>

<fieldset class="tab" id="contenttab">
	<?php if (count($aModules) == 0) : ?>
		
	<div class="pagemodule">
		<div class="modulelabel">&nbsp;</div>
		<div class="modulecontent"><?php echo Lang::get('page.label.nomodules'); ?></div>
	</div>
	<?php else: ?>
		<?php foreach ($aModules as $oModule) :?>
			<?php echo $oModule->getContents(); ?>
		<?php endforeach; ?>
	<?php endif;?>
</fieldset>

<fieldset class="tab" id="accesstab">
	<div class="pagemodule">
		<div class="modulelabel">&nbsp;</div>
		<div class="modulecontent">
			<?php if (count($userGroups) == 0) : ?>
			<?php echo Lang::get('page.label.nousergroups'); ?>
			<?php else : ?>
			<ul>
				<?php foreach ($userGroups as $userGroup) : ?>
				<li><?php echo $form->getFormElement('usergroup_'.$userGroup->getID()); ?> <?php echo $userGroup->getTitle(); ?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</div>
	</div>
</fieldset>

<fieldset class="actions">
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('page.label.actions'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('save'); ?>

			<?php if ($pagesavedredirect !== null) : ?>
			<a href="<?php echo Conf::get('general.url.www').'/'.$pagesavedredirect; ?>" class="button"><?php echo Lang::get('general.button.cancel'); ?></a>
			<?php else : ?>
			<a href="<?php echo Conf::get('general.url.www').'/page/folder/'.$folderid; ?>" class="button"><?php echo Lang::get('general.button.cancel'); ?></a>
			<?php endif; ?>
		</div>
	</div>
</fieldset>

<?php echo $form->end(); ?>

