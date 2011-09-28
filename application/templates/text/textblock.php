<?php

if (isset($htmlEditor) && $htmlEditor == true) {
//	$this->addStyle('http://yui.yahooapis.com/2.8.1/build/assets/skins/sam/skin.css');
//	$this->addStyle(Conf::get('general.url.css').'/editors.css');

	$this->addScript(Conf::get('general.url.js').'/libs/tiny_mce/tiny_mce.js');
//	$this->addScript('http://yui.yahooapis.com/2.8.1/build/yahoo-dom-event/yahoo-dom-event.js');
//	$this->addScript('http://yui.yahooapis.com/2.8.1/build/element/element-min.js');
//	$this->addScript('http://yui.yahooapis.com/2.8.1/build/container/container_core-min.js');
//	$this->addScript('http://yui.yahooapis.com/2.8.1/build/menu/menu-min.js');
//	$this->addScript('http://yui.yahooapis.com/2.8.1/build/editor/editor-min.js');

//	$this->addScript(Conf::get('general.url.js').'/cms/editors.js');
	$this->addScript(Conf::get('general.url.js').'/cms/editors2.js');
}

?>
<div class="pagemodule <?php echo $identifier; ?>">
	<div class="modulelabel">
		<h2><?php echo $label; ?></h2>
	</div>
	<?php if (isset($htmlEditor) && $htmlEditor == true) : ?>
	<div class="modulecontent yui-skin-sam mce-editor">
	<?php else : ?>
	<div class="modulecontent">
	<?php endif; ?>
	<?php echo $form->getFormElement($identifier)->addAttribute('class', 'moduletextblock '.$identifier)->addAttribute('rows', 50)->addAttribute('cols', 50); ?>
	</div>
	<div class="clear">&nbsp;</div>
</div>
