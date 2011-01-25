<ul id="dashboardmenu">
	<li<?php echo $dashboardActive; ?>><a href="<?php echo $wwwurl; ?>/dashboard">Overzicht</a></li>
	<li<?php echo $verkoopActive; ?>><a href="<?php echo $wwwurl; ?>/dashboard?p=verkoop">Mijn verkoop</a></li>
	<li<?php echo $aankoopActive; ?>><a href="<?php echo $wwwurl; ?>/dashboard?p=aankoop">Mijn aankoop</a></li>
	<li<?php echo $gegevensActive; ?>><a href="<?php echo $wwwurl; ?>/dashboard?p=gegevens">Mijn gegevens</a></li>
	<li<?php echo $berichtenActive; ?>><a href="<?php echo $wwwurl; ?>/dashboard?p=berichten">Mijn berichten</a><span class="newitems">2</span></li>
	<li<?php echo $agendaActive; ?>><a href="<?php echo $wwwurl; ?>/dashboard?p=agenda">Mijn agenda</a></li>
</ul>

<?php echo $dashboardpage; ?>