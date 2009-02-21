			<fieldset>
				<legend>New template folder</legend>
				<form action="<?php echo WWW_URL ?>/template/editfolder/" method="post">
				
					<?php if (count($aErrors) > 0) : ?>
					<ul class="error">
					<?php foreach ($aErrors as $sError) : ?>
						<li><?php echo Lang::get('login.'.$sError); ?></li>
					<?php endforeach; ?>
					</ul>
					<?php endif; ?>
					
					<table>
						<thead></thead>
						
						<tbody>
							<tr>
								<td><label for="titlevalue">Title: </label></td>
								<td>
									<input type="text" name="titlevalue" value="<?php echo $titlevalue; ?>" id="titlevalue" />
								</td>
							</tr>
							<tr>
								<td><label for="">Description: </label></td>
								<td>
									<textarea id="descriptionvalue" name="descriptionvalue" rows="4" cols="40"><?php echo $descriptionvalue; ?></textarea>
								</td>
							</tr>
						</tbody>
						
						<tfoot>
							<tr>
								<td></td>
								<td>
									<input type="submit" name="action" value="save" />
									<input type="submit" name="action" value="cancel" />
								</td>
							</tr>
						</tfoot>
					</table>
					
					<input type="hidden" name="folderid" value="<?php echo $folderid; ?>" />
					
				</form>
			</fieldset>