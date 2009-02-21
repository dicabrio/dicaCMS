			<h2>New Page</h2>
			<fieldset>
				<legend>New page</legend>
				<form action="<?php echo WWW_URL; ?>/page/editpage/" name="newpage" method="post">
					<table>
						<thead></thead>
						<tbody>
							<tr>
								<td>
									<label for="pagename">Pagename: </label>
								</td>
								<td>
									<input type="text" name="pagename" id="pagename" />.php
								</td>
							</tr>
							<tr>
								<td>
									<label for="template">Template: </label>
								</td>
								<td>
									<select name="template">
										<option value="0">Select template..</option>
										<?php foreach ($aTemplates as $oTemplateFile) : ?>
										<option value="<?php echo $oTemplateFile->getID(); ?>"><?php echo $oTemplateFile->getTitle(); ?></option>
										<?php endforeach; ?>
									</select>
									Template cannot be changed
								</td>
							</tr>
							<tr>
								<td>
									<label for="publishtime">Publishtime: </label>
								</td>
								<td>
									<input type="text" name="publishtime" id="publishtime" value="" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="expiretime">Expiretime: </label>
								</td>
								<td>
									<input type="text" name="expiretime" id="expiretime" value="" />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
									<input type="submit" value="save" name="save" />
									<input type="submit" value="cancel" name="cancel" />
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</fieldset>