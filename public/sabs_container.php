<?php
	$sabsOptions = get_option('sabs');

	// Size implementation
	$sabsSize = (!empty($sabsOptions) && $sabsOptions['size'] ? $sabsOptions['size'] : 2);
	$sabsSizeClass = '';

	if($sabsSize == 1) {
		$sabsSizeClass = 'sabs-size-small';
	} else if($sabsSize == 3) {
		$sabsSizeClass = 'sabs-size-large';
	}

	// Direction implementation
	$sabsDirection = (!empty($sabsOptions) && $sabsOptions['direction'] ? $sabsOptions['direction'] : 'vertical');
	$sabsDirectionClass = '';

	if($sabsDirection == 'horizontal') {
		$sabsDirectionClass = 'sabs-direction-horizontal';
	}

	// Placement implementation
	$sabsPlacement = (!empty($sabsOptions) && $sabsOptions['placement'] ? $sabsOptions['placement'] : 'right');
	$sabsPlacementClass = '';

	switch ($sabsPlacement) {
		case 'left':
			$sabsPlacementClass = 'sabs-placement-left';
			break;
		case 'topLeft':
			$sabsPlacementClass = 'sabs-placement-top-left';
			break;
		case 'bottomLeft':
			$sabsPlacementClass = 'sabs-placement-bottom-left';
			break;
		case 'topRight':
			$sabsPlacementClass = 'sabs-placement-top-right';
			break;
		case 'bottomRight':
			$sabsPlacementClass = 'sabs-placement-bottom-right';
			break;
	}

	// View Mode
	$sabsViewMode = (!empty($sabsOptions) && $sabsOptions['viewMode'] ? $sabsOptions['viewMode'] : 'always');
	$sabsViewModeClass = '';

	if($sabsViewMode == 'collapsible') {
		$sabsViewModeClass = 'sabs-view-mode-collapsible';
	}

	// Collapse Mode
	if($sabsViewMode == 'collapsible') {
		$sabsCollapseMode = (!empty($sabsOptions) && $sabsOptions['collapseMode'] ? $sabsOptions['collapseMode'] : 'hover');

		if($sabsCollapseMode == 'click') {
			$sabsViewModeClass .= ' sabs-collapsible-mode-click';
		}
	}

	// Collapse Button Style
	if($sabsViewMode == 'collapsible') {
		$sabsCollapseButton = (!empty($sabsOptions) && $sabsOptions['collapseButton'] ? $sabsOptions['collapseButton'] : []);

		$sabsCollapseButton = [
			'icon' => isset($sabsCollapseButton['icon']) && !empty($sabsCollapseButton['icon']) ? $sabsCollapseButton['icon'] : 'icofont-chat',
			'bgColor' => isset($sabsCollapseButton['bgColor']) && !empty($sabsCollapseButton['bgColor']) ? $sabsCollapseButton['bgColor'] : '#512da8',
			'color' => isset($sabsCollapseButton['color']) && !empty($sabsCollapseButton['color']) ? $sabsCollapseButton['color'] : '#ffffff',
		];
	}

	$sabsButtons = $sabsOptions['buttons'] ?? [];
?>

<div class="sabs-container sabs-hide-container <?php echo esc_attr($sabsSizeClass); ?> <?php echo esc_attr($sabsDirectionClass); ?> <?php echo esc_attr($sabsPlacementClass); ?> <?php echo esc_attr($sabsViewModeClass); ?>">
	<?php
		// Create Default Button #1 (if value provided)
		if(isset($sabsButtons['whatsApp'])) {
	?>
		<a href="https://wa.me/<?php echo esc_attr(str_replace(' ', '', $sabsButtons['whatsApp'])); ?>" class="sab sab-whatsapp sab-with-notification" tabindex="-1">
			<i class="icofont-whatsapp"></i>
		</a>
	<?php
		}
		// Create Default Button #2 (if value provided)
		if(isset($sabsButtons['phone'])) {
	?>
		<a href="tel:<?php echo esc_attr($sabsButtons['phone']); ?>" class="sab sab-phone" tabindex="-1">
			<i class="icofont-phone"></i>
		</a>
	<?php
		}
		// Create Default Button #3 (if value provided)
		if(isset($sabsButtons['email'])) {
	?>
		<a href="mailto:<?php echo esc_attr($sabsButtons['email']); ?>" class="sab sab-email" tabindex="-1">
			<i class="icofont-email"></i>
		</a>
	<?php
		}
		// Create Custom Buttons
		if(isset($sabsOptions['customButtons']) && !empty($sabsOptions['customButtons'])) {
			foreach($sabsOptions['customButtons'] as $sabsCustomBtn) {
	?>
		<a class="sab <?php if(($sabsCustomBtn['withNotificationIcon'] ?? 'no') == 'yes') { ?>sab-with-notification<?php } ?>" tabindex="-1" href="<?php if($sabsCustomBtn['actionType'] == 'link') { echo esc_attr($sabsCustomBtn['action']); } else { echo esc_attr('javascript:void(0);'); } ?>" <?php if($sabsCustomBtn['actionType'] == 'js-function') { ?>onclick="<?php echo esc_attr($sabsCustomBtn['action']); ?>"<?php } ?> style="background-color: <?php echo esc_attr($sabsCustomBtn['bgColor']); ?>; color: <?php echo esc_attr($sabsCustomBtn['color']); ?>;">
			<i class="<?php echo esc_attr($sabsCustomBtn['icon']); ?>"></i>
		</a>
	<?php
			}
		}

		// Create [Toggle Collapsible Button] (if View Mode is set as Collapsible)
		if($sabsViewMode == 'collapsible') {
	?>
		<a href="javascript:void(0);" class="sab sab-toggle-collapsible" tabindex="-1" style="background-color: <?php echo esc_attr($sabsCollapseButton['bgColor']); ?>; color: <?php echo esc_attr($sabsCollapseButton['color']); ?>;">
			<i class="sab-ic-default <?php echo esc_attr($sabsCollapseButton['icon']); ?>"></i>
			<i class="sab-ic-on-shown icofont-close"></i>
		</a>
	<?php } ?>
</div>