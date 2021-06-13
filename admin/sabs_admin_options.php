<div class="wrap">
	<h1>Sticky Action Buttons</h1>

	<?php
		$currFabOptions = get_option('sabs');
		$errors = isset($_SESSION['sabsValidationErrors']) && !empty($_SESSION['sabsValidationErrors']) ? $_SESSION['sabsValidationErrors'] : [];
		$sabsOldFormData = isset($_SESSION['sabsOldFormData']) && !empty($_SESSION['sabsOldFormData']) ? $_SESSION['sabsOldFormData'] : [];

		if(!empty($errors)) {
			unset($_SESSION['sabsValidationErrors']);
		}

		if(!empty($sabsOldFormData)) {
			unset($_SESSION['sabsOldFormData']);
		}

		if(isset($_SESSION['saveSuccess'])) {
			$saveSuccess = $_SESSION['saveSuccess'];
			unset($_SESSION['saveSuccess']);
		}

		if(isset($_SESSION['invalidDataAlert'])) {
			$invalidDataAlert = $_SESSION['invalidDataAlert'];
			unset($_SESSION['invalidDataAlert']);
		}
	?>

	<?php if(isset($saveSuccess)): ?>
	<div class="notice notice-success is-dismissible">
		<p><?php _e( 'All changes are saved!' ); ?></p>
	</div>
	<?php elseif(isset($invalidDataAlert)): ?>
	<div class="notice notice-error is-dismissible">
		<p><?php _e( 'Invalid data found. Please correct them all and continue.' ); ?></p>
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
								<input type="checkbox" name="sabs[enabled]" id="sabs-enabled" class="" value="yes" <?php if(($sabsOldFormData['enabled'] ?? ($currFabOptions['enabled'] ?? 'no')) == 'yes'): ?> checked <?php endif; ?>>
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
								<input type="text" name="sabs[whatsApp]" id="sabs-whatsApp" class="<?php if(isset($errors['whatsApp'])): ?>invalid<?php endif; ?>" value="<?php _e($sabsOldFormData['whatsApp'] ?? ($currFabOptions['buttons']['whatsApp'] ?? '')); ?>" placeholder="Enter Your WhatsApp No">
								<?php if(isset($errors['whatsApp'])): ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php endif; ?>
							</label>
						</fieldset>
						<p class="description">
							<i class="icofont-info-circle"></i> Mobile number should be in the format: <code>[+][Country Code][Your 10 Digit Mobile Number]</code>.<br>For example: +919876543210 (Without any spaces)
						</p>
						<?php if(isset($errors['whatsApp'])): ?>
						<p class="description invalid-feedback"><?php _e($errors['whatsApp']); ?></p>
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
								<input type="text" name="sabs[phone]" id="sabs-phone" class="<?php if(isset($errors['phone'])): ?>invalid<?php endif; ?>" value="<?php _e($sabsOldFormData['phone'] ?? ($currFabOptions['buttons']['phone'] ?? '')); ?>" placeholder="Enter Your Phone Number">
								<?php if(isset($errors['phone'])): ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php endif; ?>
							</label>
						</fieldset>
						<p class="description">
							<i class="icofont-info-circle"></i> Mobile number should be in the format: <code>[+][Country Code][Your 10 Digit Mobile Number]</code>.<br>For example: +919876543210 (Without any spaces)
						</p>
						<?php if(isset($errors['phone'])): ?>
						<p class="description invalid-feedback"><?php _e($errors['phone']); ?></p>
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
								<input type="email" name="sabs[email]" id="sabs-email" class="regular-text <?php if(isset($errors['email'])): ?>invalid<?php endif; ?>" value="<?php _e($sabsOldFormData['email'] ?? ($currFabOptions['buttons']['email'] ?? '')); ?>" placeholder="Enter Your E-mail Address">
								<?php if(isset($errors['email'])): ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php endif; ?>
							</label>
						</fieldset>
						<?php if(isset($errors['email'])): ?>
						<p class="description invalid-feedback"><?php _e($errors['email']); ?></p>
						<?php endif; ?>
					</td>
				</tr>
			</tbody>
		</table>

		<input type="submit" class="button button-primary" name="submit" value="Save Changes">
	</form>
</div>