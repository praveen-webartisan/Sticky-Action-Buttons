<div class="wrap">
	<h1>Sticky Action Buttons</h1>

	<?php
		$currFabOptions = get_option('sabs');
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
					<th></th>
					<td colspan="2">
						<fieldset>
							<label for="sabs-enabled">
								<input type="checkbox" name="sabsEnabled" id="sabs-enabled" class="" value="yes" <?php if((isset($oldEnabled) ? $oldEnabled : (isset($currFabOptions['enabled']) ? $currFabOptions['enabled'] : 'no')) == 'yes'): ?> checked <?php endif; ?>>
								Enable the Buttons
							</label>
						</fieldset>
						<p class="description">
							<i class="icofont-info-circle"></i> Select this option to <b>Show</b> the buttons on your website
						</p>
					</td>
				</tr>
				<tr>
					<th>
						<p class="text-align-center">
							<a href="javascript:void(0);" class="fab sab-whatsapp" tabindex="-1">
								<i class="icofont-whatsapp"></i>
							</a>
						</p>
						<p class="text-align-center">WhatsApp</p>
					</th>
					<td>
						<fieldset>
							<label for="sabs-whatsApp">
								<input type="text" name="sabsWhatsApp" id="sabs-whatsApp" class="<?php if(isset($errWhatsApp)): ?>invalid<?php endif; ?>" value="<?php echo esc_attr(isset($oldWhatsApp) ? $oldWhatsApp :($currFabOptions['buttons']['whatsApp'] ?? '')); ?>" placeholder="Enter Your WhatsApp No">
								<?php if(isset($errWhatsApp)): ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php endif; ?>
							</label>
						</fieldset>
						<p class="description">
							<i class="icofont-info-circle"></i> Mobile number should be in the format: <code>[+][Country Code][Your 10 Digit Mobile Number]</code>.<br>For example: +919876543210 (Without any spaces)
						</p>
						<?php if(isset($errWhatsApp)): ?>
						<p class="description invalid-feedback"><?php echo esc_html($errWhatsApp); ?></p>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th>
						<p class="text-align-center">
							<a href="javascript:void(0);" class="fab sab-phone" tabindex="-1">
								<i class="icofont-phone"></i>
							</a>
						</p>
						<p class="text-align-center">Call</p>
					</th>
					<td>
						<fieldset>
							<label for="sabs-phone">
								<input type="text" name="sabsPhone" id="sabs-phone" class="<?php if(isset($errPhone)): ?>invalid<?php endif; ?>" value="<?php echo esc_attr(isset($oldPhone) ? $oldPhone : ($currFabOptions['buttons']['phone'] ?? '')); ?>" placeholder="Enter Your Phone Number">
								<?php if(isset($errPhone)): ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php endif; ?>
							</label>
						</fieldset>
						<p class="description">
							<i class="icofont-info-circle"></i> Mobile number should be in the format: <code>[+][Country Code][Your 10 Digit Mobile Number]</code>.<br>For example: +919876543210 (Without any spaces)
						</p>
						<?php if(isset($errPhone)): ?>
						<p class="description invalid-feedback"><?php echo esc_html($errPhone); ?></p>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th>
						<p class="text-align-center">
							<a href="javascript:void(0);" class="fab sab-email" tabindex="-1">
								<i class="icofont-email"></i>
							</a>
						</p>
						<p class="text-align-center">E-Mail</p>
					</th>
					<td>
						<fieldset>
							<label for="sabs-email">
								<input type="email" name="sabsEmail" id="sabs-email" class="regular-text <?php if(isset($errEmail)): ?>invalid<?php endif; ?>" value="<?php echo esc_attr(isset($oldEmail) ? $oldEmail : ($currFabOptions['buttons']['email'] ?? '')); ?>" placeholder="Enter Your E-mail Address">
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
			</tbody>
		</table>

		<input type="submit" class="button button-primary" name="submit" value="Save Changes">
	</form>
</div>