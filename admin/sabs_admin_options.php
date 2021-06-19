<div class="wrap">
	<h1>Sticky Action Buttons</h1>

	<?php
		$currSabOptions = isset($currSabOptions) && !empty($currSabOptions) ? $currSabOptions : [];
	?>

	<?php if(isset($saveSuccess)): ?>
	<div class="notice notice-success is-dismissible">
		<p><?php echo esc_html( 'All changes are saved!' ); ?></p>
	</div>
	<?php elseif(isset($invalidDataAlert)): ?>
	<div class="notice notice-error is-dismissible">
		<p><?php echo esc_html( 'Invalid data found. Please correct them all and continue.' ); ?></p>
	</div>
	<?php endif; ?>

	<form action="<?php menu_page_url('sabs-admin-options') ?>" method="post">
		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<p class="text-align-center">
							<a href="javascript:void(0);" class="sab sab-whatsapp" tabindex="-1">
								<i class="icofont-whatsapp"></i>
							</a>
						</p>
						<p class="text-align-center">WhatsApp</p>
					</th>
					<td>
						<fieldset>
							<label for="sabs-whatsApp">
								<input type="text" name="sabsWhatsApp" id="sabs-whatsApp" class="<?php if(isset($errWhatsApp)): ?>invalid<?php endif; ?>" value="<?php echo esc_attr(isset($oldWhatsApp) ? $oldWhatsApp :($currSabOptions['buttons']['whatsApp'] ?? '')); ?>" placeholder="Enter Your WhatsApp No">
								<?php if(isset($errWhatsApp)): ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php endif; ?>
							</label>
						</fieldset>
						<p class="description">
							Mobile number should be in the format: <code>[+][Country Code][Your 10 Digit Mobile Number]</code>.<br>For example: +919876543210 (Without any spaces)
						</p>
						<?php if(isset($errWhatsApp)): ?>
						<p class="description invalid-feedback"><?php echo esc_html($errWhatsApp); ?></p>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th>
						<p class="text-align-center">
							<a href="javascript:void(0);" class="sab sab-phone" tabindex="-1">
								<i class="icofont-phone"></i>
							</a>
						</p>
						<p class="text-align-center">Call</p>
					</th>
					<td>
						<fieldset>
							<label for="sabs-phone">
								<input type="text" name="sabsPhone" id="sabs-phone" class="<?php if(isset($errPhone)): ?>invalid<?php endif; ?>" value="<?php echo esc_attr(isset($oldPhone) ? $oldPhone : ($currSabOptions['buttons']['phone'] ?? '')); ?>" placeholder="Enter Your Phone Number">
								<?php if(isset($errPhone)): ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php endif; ?>
							</label>
						</fieldset>
						<p class="description">
							Mobile number should be in the format: <code>[+][Country Code][Your 10 Digit Mobile Number]</code>.<br>For example: +919876543210 (Without any spaces)
						</p>
						<?php if(isset($errPhone)): ?>
						<p class="description invalid-feedback"><?php echo esc_html($errPhone); ?></p>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th>
						<p class="text-align-center">
							<a href="javascript:void(0);" class="sab sab-email" tabindex="-1">
								<i class="icofont-email"></i>
							</a>
						</p>
						<p class="text-align-center">E-Mail</p>
					</th>
					<td>
						<fieldset>
							<label for="sabs-email">
								<input type="email" name="sabsEmail" id="sabs-email" class="regular-text <?php if(isset($errEmail)): ?>invalid<?php endif; ?>" value="<?php echo esc_attr(isset($oldEmail) ? $oldEmail : ($currSabOptions['buttons']['email'] ?? '')); ?>" placeholder="Enter Your E-mail Address">
								<?php if(isset($errEmail)): ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php endif; ?>
							</label>
						</fieldset>
						<?php if(isset($errEmail)): ?>
						<p class="description invalid-feedback"><?php echo esc_html($errEmail); ?></p>
						<?php endif; ?>
					</td>
				</tr>
				<tr id="trAddCustomSab">
					<td></td>
					<td>
						<button type="button" class="button button-primary" id="btnAddCustomSab">
							<i class="icofont-plus"></i> Add Custom Button
						</button>
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<fieldset>
							<label for="sabs-enabled">
								<input type="checkbox" name="sabsEnabled" id="sabs-enabled" class="" value="yes" <?php if((isset($oldEnabled) ? $oldEnabled : (isset($currSabOptions['enabled']) ? $currSabOptions['enabled'] : 'no')) == 'yes'): ?> checked <?php endif; ?>>
								Enable the Buttons
							</label>
						</fieldset>
						<p class="description">
							Unselect this option to <b>Hide</b> the Buttons to the Visitors.
						</p>

						<br>

						<fieldset>
							<p>Size: <span id="strSabsSize"></span></p>
							<label for="sabs-size">
								<input type="range" name="sabsSize" id="sabs-size" class="" min="1" value="<?php echo esc_attr(isset($oldSabsSize) ? $oldSabsSize : (isset($currSabOptions['size']) ? $currSabOptions['size'] : '2')); ?>" max="3">
							</label>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>

		<input type="submit" class="button button-primary" name="submit" value="Save Changes">
	</form>
</div>

<script type="text/html" id="tmplAddCustomSabRow">
	<tr class="trCustomSab">
		<td>
			<p class="text-align-center">
				<a href="javascript:void(0);" class="sab" tabindex="-1">
					<i class="sab-custom-icon"></i>
				</a>
			</p>
			<fieldset class="" style="margin-top: 10px;">
				<p>
					Background Color: 
				</p>
				<label for="sabsCustom_INDEX_bgColor">
					<input type="color" name="sabsCustom[INDEX][bgColor]" id="sabsCustom_INDEX_bgColor" class="sabsCustom-bgColor" value="#512da8" data-default-color="#512da8" size="10" required>
				</label>
			</fieldset>
			<fieldset class="">
				<p>
					Icon Color: 
				</p>
				<label for="sabsCustom_INDEX_color">
					<input type="color" name="sabsCustom[INDEX][color]" id="sabsCustom_INDEX_color" class="sabsCustom-color" value="#ffffff" data-default-color="#ffffff" size="10" required>
				</label>
			</fieldset>
		</td>
		<td>
			<fieldset class="">
				<label for="">
					<input type="text" name="sabsCustom[INDEX][icon]" id="sabsCustom_INDEX_icon" class="sabsCustom-icon" value="" placeholder="Icon" size="10" required>
				</label>
			</fieldset>
			<p class="description">
				Enter any of the icon class from IcoFont package.<br> Get the Icon name <a href="https://icofont.com/icons" target="_blank">here <i class="icofont-external-link"></i></a>
			</p>
			<br>
			<fieldset>
				<label for="">
					<input type="text" name="sabsCustom[INDEX][action]" id="sabsCustom_INDEX_action" class="regular-text sabsCustom-action" value="" placeholder="URL Link or JavaScript Function" required>
				</label>
			</fieldset>
			<p class="description">
				Enter any URL or JavaScript Function as the Click Action to this Button
			</p>
			<br>
			<fieldset>
				<label for="sabsCustom_INDEX_withNotificationIcon">
					<input type="checkbox" name="sabsCustom[INDEX][withNotificationIcon]" id="sabsCustom_INDEX_withNotificationIcon" class="sabsCustom-withNotificationIcon" value="yes">
					With Notification Icon
				</label>
			</fieldset>
			<div class="trCustomSabActionsContaienr">
				<a href="javascript:void(0);" class="btnDeleteCustomSab" title="Delete">
					<i class="icofont-ui-delete"></i>
				</a>
			</div>
		</td>
	</tr>
</script>