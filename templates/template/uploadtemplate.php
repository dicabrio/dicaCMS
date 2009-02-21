			<fieldset>
				<legend>Upload template</legend>
				<form action="<?php echo WWW_URL; ?>/template/edittemplate" method="post" enctype="multipart/form-data">
					<?php if (count($aErrors) > 0) : ?>
					<ul class="error">
					<?php foreach ($aErrors as $sError) : ?>
						<li><?php echo Lang::get($sError); ?></li>
					<?php endforeach; ?>
					</ul>
					<?php endif; ?>
					<table>
						<tbody>
							<tr>
								<td><label for="titlevalue">Title: </label></td>
								<td>
									<input type="text" name="titlevalue" value="<?php echo $titlevalue; ?>" id="titlevalue" />
								</td>
							</tr>
							<tr>
								<td><label for="descriptionvalue">Description: </label></td>
								<td>
									<textarea rows="2" cols="40" name="descriptionvalue"><?php echo $descriptionvalue; ?></textarea>
								</td>
							</tr>
							<tr>
								<td><label for="templatefile">File: </label></td>
								<td>
									<input type="file" name="templatefile" />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
									<input type="submit" name="action" value="save" />
									<input type="submit" name="action" value="cancel" />
								</td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" name="templateid" value="<?php echo $templateid; ?>" />
				</form>
				
			</fieldset>