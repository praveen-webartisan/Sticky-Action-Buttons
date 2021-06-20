<div class="wrap">
	<h1>Sticky Action Buttons</h1>

	<?php
		/**
		 * Construct Variables
		 * 
		 * old[variable] are previously submitted values
		 * curr[variable] are saved values from Database
		 * 
		 * */

		$currSabOptions = isset($currSabOptions) && !empty($currSabOptions) ? $currSabOptions : [];

		// Button size
		$sabsSize = (isset($oldSabsSize) ? $oldSabsSize : (isset($currSabOptions['size']) ? $currSabOptions['size'] : 2));

		// Direction
		$sabsDirection = (isset($oldSabsDirection) ? $oldSabsDirection : (isset($currSabOptions['direction']) ? $currSabOptions['direction'] : 'vertical'));

		// Placement
		$sabsPlacement = (isset($oldSabsPlacement) ? $oldSabsPlacement : (isset($currSabOptions['placement']) ? $currSabOptions['placement'] : 'right'));

		// View Mode
		$sabsViewMode = (isset($oldSabsViewMode) ? $oldSabsViewMode : (isset($currSabOptions['viewMode']) ? $currSabOptions['viewMode'] : 'always'));

		// Collapsible Mode
		$sabsCollapseMode = (isset($oldSabsCollapseMode) ? $oldSabsCollapseMode : (isset($currSabOptions['collapseMode']) ? $currSabOptions['collapseMode'] : 'hover'));

		// Toggle Collapsible button style
		$sabsCollapseButtonIcon = (isset($oldSabsCollapseButtonIcon) ? $oldSabsCollapseButtonIcon : (isset($currSabOptions['collapseButton']['icon']) ? $currSabOptions['collapseButton']['icon'] : 'icofont-chat'));
		$sabsCollapseButtonBgColor = (isset($oldSabsCollapseButtonBgColor) ? $oldSabsCollapseButtonBgColor : (isset($currSabOptions['collapseButton']['bgColor']) ? $currSabOptions['collapseButton']['bgColor'] : '#512da8'));
		$sabsCollapseButtonIconColor = (isset($oldSabsCollapseButtonIconColor) ? $oldSabsCollapseButtonIconColor : (isset($currSabOptions['collapseButton']['color']) ? $currSabOptions['collapseButton']['color'] : '#ffffff'));
	?>

	<?php
		// Show Success/Failure Messages
		if(isset($saveSuccess)) {
	?>
	<div class="notice notice-success is-dismissible">
		<p><?php echo esc_html( 'All changes are saved!' ); ?></p>
	</div>
	<?php } elseif(isset($invalidDataAlert)) { ?>
	<div class="notice notice-error is-dismissible">
		<p><?php echo esc_html( 'Invalid data found. Please correct them all and continue.' ); ?></p>
	</div>
	<?php } ?>

	<form action="<?php menu_page_url('sabs-admin-options') ?>" method="post">
		<table class="form-table">
			<tbody>
				<!-- Default Button #1 -->
				<tr>
					<th>
						<p class="text-align-center">
							<!-- Button preview -->
							<a href="javascript:void(0);" class="sab sab-whatsapp" tabindex="-1">
								<i class="icofont-whatsapp"></i>
							</a>
						</p>
						<p class="text-align-center">WhatsApp</p>
					</th>
					<td>
						<fieldset>
							<label for="sabs-whatsApp">
								<!-- Button Link Text -->
								<input type="text" name="sabsWhatsApp" id="sabs-whatsApp" class="<?php if(isset($errWhatsApp)) { ?>invalid<?php } ?>" value="<?php echo esc_attr(isset($oldWhatsApp) ? $oldWhatsApp :($currSabOptions['buttons']['whatsApp'] ?? '')); ?>" placeholder="Enter Your WhatsApp No">
								<?php if(isset($errWhatsApp)) { ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php } ?>
							</label>
						</fieldset>
						<p class="description">
							Mobile number should be in the format: <code>[+][Country Code][Your 10 Digit Mobile Number]</code>.<br>For example: <code>+919876543210</code> (Without any spaces)
						</p>
						<?php
							// Show Validation message (if exists)
							if(isset($errWhatsApp)) {
						?>
						<p class="description invalid-feedback"><?php echo esc_html($errWhatsApp); ?></p>
						<?php } ?>
					</td>
				</tr>
				<!-- Default Button #2 -->
				<tr>
					<th>
						<p class="text-align-center">
							<!-- Button preview -->
							<a href="javascript:void(0);" class="sab sab-phone" tabindex="-1">
								<i class="icofont-phone"></i>
							</a>
						</p>
						<p class="text-align-center">Call</p>
					</th>
					<td>
						<fieldset>
							<label for="sabs-phone">
								<!-- Button Link Text -->
								<input type="text" name="sabsPhone" id="sabs-phone" class="<?php if(isset($errPhone)) { ?>invalid<?php } ?>" value="<?php echo esc_attr(isset($oldPhone) ? $oldPhone : ($currSabOptions['buttons']['phone'] ?? '')); ?>" placeholder="Enter Your Phone Number">
								<?php if(isset($errPhone)) { ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php } ?>
							</label>
						</fieldset>
						<p class="description">
							Mobile number should be in the format: <code>[+][Country Code][Your 10 Digit Mobile Number]</code>.<br>For example: <code>+919876543210</code> (Without any spaces)
						</p>
						<?php
							// Show Validation message (if exists)
							if(isset($errPhone)) {
						?>
						<p class="description invalid-feedback"><?php echo esc_html($errPhone); ?></p>
						<?php } ?>
					</td>
				</tr>
				<!-- Default Button #3 -->
				<tr>
					<th>
						<p class="text-align-center">
							<!-- Button preview -->
							<a href="javascript:void(0);" class="sab sab-email" tabindex="-1">
								<i class="icofont-email"></i>
							</a>
						</p>
						<p class="text-align-center">E-Mail</p>
					</th>
					<td>
						<fieldset>
							<label for="sabs-email">
								<!-- Button Link Text -->
								<input type="email" name="sabsEmail" id="sabs-email" class="regular-text <?php if(isset($errEmail)) { ?>invalid<?php } ?>" value="<?php echo esc_attr(isset($oldEmail) ? $oldEmail : ($currSabOptions['buttons']['email'] ?? '')); ?>" placeholder="Enter Your E-mail Address">
								<?php if(isset($errEmail)) { ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php } ?>
							</label>
						</fieldset>
						<?php
							// Show Validation message (if exists)
							if(isset($errEmail)) {
						?>
						<p class="description invalid-feedback"><?php echo esc_html($errEmail); ?></p>
						<?php } ?>
					</td>
				</tr>
				<!-- Add Custom Button Options -->
				<tr id="trAddCustomSab">
					<td></td>
					<td>
						<fieldset>
							<button type="button" class="button button-primary" id="btnAddCustomSab">
								<i class="icofont-plus"></i> Add Custom Button
							</button>
						</fieldset>
					</td>
				</tr>
				<!-- Button Styling Options -->
				<tr>
					<td></td>
					<td>
						<!-- Button Size -->
						<fieldset>
							<p>Size: <span id="strSabsSize"></span></p>
							<label for="sabs-size">
								<input type="range" name="sabsSize" id="sabs-size" class="" min="1" value="<?php echo esc_attr($sabsSize); ?>" max="3">
							</label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<fieldset>
							<!-- Direction -->
							<div style="float: left;">
								<p>Direction:</p>
								<label for="sabsDirection">
									<select class="" id="sabsDirection" name="sabsDirection">
										<option value="vertical" <?php if($sabsDirection == 'vertical') { ?> selected <?php } ?>>Vertical</option>
										<option value="horizontal" <?php if($sabsDirection == 'horizontal') { ?> selected <?php } ?>>Horizontal</option>
									</select>
								</label>
							</div>
							<!-- Placement -->
							<div style="float: left; margin-left: 20px;">
								<p>Placement:</p>
								<label for="sabsPlacement">
									<select class="" id="sabsPlacement" name="sabsPlacement">
										<option value="topLeft" <?php if($sabsPlacement == 'topLeft') { ?> selected <?php } ?>>Top Left</option>
										<option value="left" <?php if($sabsPlacement == 'left') { ?> selected <?php } ?>>Left</option>
										<option value="bottomLeft" <?php if($sabsPlacement == 'bottomLeft') { ?> selected <?php } ?>>Bottom Left</option>
										<option value="topRight" <?php if($sabsPlacement == 'topRight') { ?> selected <?php } ?>>Top Right</option>
										<option value="right" <?php if($sabsPlacement == 'right') { ?> selected <?php } ?>>Right</option>
										<option value="bottomRight" <?php if($sabsPlacement == 'bottomRight') { ?> selected <?php } ?>>Bottom Right</option>
									</select>
								</label>
							</div>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<!-- Toggle Collapsible Button Style -->
						<fieldset class="showOnViewModeCollapsible" style="display: none;">
							<p class="text-align-center">Collapse Button</p>
							<p class="text-align-center">
								<!-- Toggle Collapsible Button Preview -->
								<a href="javascript:void(0);" class="sab" tabindex="-1">
									<i class="icofont-chat"></i>
								</a>
							</p>
						</fieldset>
						<br>
						<!-- Toggle Collapsible Button Icon -->
						<fieldset class="showOnViewModeCollapsible" style="display: none;">
							<p>
								Icon:
							</p>
							<label for="sabsCollapseButtonIcon">
								<input type="text" name="sabsCollapseButtonIcon" id="sabsCollapseButtonIcon" class="<?php if(isset($errCollapseButtonIcon)) { ?> invalid <?php } ?>" value="<?php echo esc_attr($sabsCollapseButtonIcon); ?>" placeholder="Icon" size="10" required>
								<?php if(isset($errCollapseButtonIcon)) { ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php } ?>
							</label>
						</fieldset>
						<?php
							// Show Validation message (if exists)
							if(isset($errCollapseButtonIcon)) {
						?>
						<p class="description invalid-feedback"><?php echo esc_html($errCollapseButtonIcon); ?></p>
						<?php } ?>
						<!-- Toggle Collapsible Button Background Color -->
						<fieldset class="showOnViewModeCollapsible" style="display: none;">
							<p>
								Background Color: 
							</p>
							<label for="sabsCollapseButtonBgColor">
								<input type="color" name="sabsCollapseButtonBgColor" id="sabsCollapseButtonBgColor" class="<?php if(isset($errCollapseButtonBgColor)) { ?> invalid <?php } ?>" value="<?php echo esc_attr($sabsCollapseButtonBgColor); ?>" size="10" required>
								<?php if(isset($errCollapseButtonBgColor)) { ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php } ?>
							</label>
						</fieldset>
						<?php
							// Show Validation message (if exists)
							if(isset($errCollapseButtonBgColor)) {
						?>
						<p class="description invalid-feedback"><?php echo esc_html($errCollapseButtonBgColor); ?></p>
						<?php } ?>
						<!-- Toggle Collapsible Button Icon Color -->
						<fieldset class="showOnViewModeCollapsible" style="display: none;">
							<p>
								Icon Color: 
							</p>
							<label for="sabsCollapseButtonIconColor">
								<input type="color" name="sabsCollapseButtonIconColor" id="sabsCollapseButtonIconColor" class="<?php if(isset($errCollapseButtonIconColor)) { ?> invalid <?php } ?>" value="<?php echo esc_attr($sabsCollapseButtonIconColor); ?>" size="10" required>
								<?php if(isset($errCollapseButtonIconColor)) { ?>
									<span class="invalid"><i class="icofont-warning-alt"></i></span>
								<?php } ?>
							</label>
						</fieldset>
						<?php
							// Show Validation message (if exists)
							if(isset($errCollapseButtonIconColor)) {
						?>
						<p class="description invalid-feedback"><?php echo esc_html($errCollapseButtonIconColor); ?></p>
						<?php } ?>
					</td>
					<td>
						<fieldset>
							<!-- View Mode -->
							<div style="float: left;">
								<p>View Mode:</p>
								<label for="sabsViewMode">
									<select class="" id="sabsViewMode" name="sabsViewMode">
										<option value="always" <?php if($sabsViewMode == 'always') { ?> selected <?php } ?>>Always Visible</option>
										<option value="collapsible" <?php if($sabsViewMode == 'collapsible') { ?> selected <?php } ?>>Collapsible</option>
									</select>
								</label>
							</div>
							<!-- Collapsible Mode -->
							<div class="showOnViewModeCollapsible" style="display: none; float: left; margin-left: 20px;">
								<p>Show Buttons when:</p>
								<label for="sabsCollapseMode">
									<select class="" id="sabsCollapseMode" name="sabsCollapseMode">
										<option value="hover" <?php if($sabsCollapseMode == 'hover') { ?> selected <?php } ?>>Mouse hover</option>
										<option value="click" <?php if($sabsCollapseMode == 'click') { ?> selected <?php } ?>>Click</option>
									</select>
								</label>
							</div>
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
				<!-- Custom Button Preview -->
				<a href="javascript:void(0);" class="sab" tabindex="-1">
					<i class="sab-custom-icon"></i>
				</a>
			</p>
			<!-- Custom Button Background Color -->
			<fieldset class="" style="margin-top: 10px;">
				<p>
					Background Color: 
				</p>
				<label for="sabsCustom_INDEX_bgColor">
					<input type="color" name="sabsCustom[INDEX][bgColor]" id="sabsCustom_INDEX_bgColor" class="sabsCustom-bgColor" value="#512da8" data-default-color="#512da8" size="10" required>
				</label>
			</fieldset>
			<!-- Custom Button Icon Color -->
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
			<!-- Custom Button Icon -->
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
				Enter any <b>URL</b> or<br>
				<b>JavaScript Function Name</b> (Without Parentheses) as the Click Action to this Button.<br>
				<b>Note: The JavaScript Function should be Globally accessible. i.e,</b> <code>window.[functionName]</code>.<br>
				<b>Otherwise, the Button will not be shown on the Website.</b>
			</p>
			<br>
			<!-- Custom Button - Notification Icon -->
			<fieldset>
				<label for="sabsCustom_INDEX_withNotificationIcon">
					<input type="checkbox" name="sabsCustom[INDEX][withNotificationIcon]" id="sabsCustom_INDEX_withNotificationIcon" class="sabsCustom-withNotificationIcon" value="yes">
					With Notification Icon
				</label>
			</fieldset>
			<!-- Custom Button - Actions -->
			<div class="trCustomSabActionsContaienr">
				<a href="javascript:void(0);" class="btnDeleteCustomSab" title="Delete">
					<i class="icofont-ui-delete"></i>
				</a>
			</div>
		</td>
	</tr>
</script>