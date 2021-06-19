<?php
	$sabsOptions = get_option('sabs');
	$sabsEnabled = (!empty($sabsOptions) && $sabsOptions['enabled'] == 'yes');
	$sabsSize = (!empty($sabsOptions) && $sabsOptions['size'] ? $sabsOptions['size'] : 2);
	$sabsSizeClass = "";

	if($sabsSize == 1) {
		$sabsSizeClass = "sabs-size-small";
	} else if($sabsSize == 3) {
		$sabsSizeClass = "sabs-size-large";
	}

	$sabsButtons = $sabsOptions['buttons'] ?? [];

	if($sabsEnabled && !empty($sabsButtons)):
?>

<div class="sabs-container <?php echo esc_attr($sabsSizeClass); ?>">
	<?php if(isset($sabsButtons['whatsApp'])): ?>
		<a href="https://wa.me/<?php echo esc_attr(str_replace(' ', '', $sabsButtons['whatsApp'])); ?>" class="sab sab-whatsapp sab-with-notification" tabindex="-1">
			<i class="icofont-whatsapp"></i>
		</a>
	<?php endif; ?>
	<?php if(isset($sabsButtons['phone'])): ?>
		<a href="tel:<?php echo esc_attr($sabsButtons['phone']); ?>" class="sab sab-phone" tabindex="-1">
			<i class="icofont-phone"></i>
		</a>
	<?php endif; ?>
	<?php if(isset($sabsButtons['email'])): ?>
		<a href="mailto:<?php echo esc_attr($sabsButtons['email']); ?>" class="sab sab-email" tabindex="-1">
			<i class="icofont-email"></i>
		</a>
	<?php endif; ?>
	<?php
		if(isset($sabsOptions['customButtons']) && !empty($sabsOptions['customButtons'])):
			foreach($sabsOptions['customButtons'] as $sabsCustomBtn):
	?>
		<a class="sab <?php if(($sabsCustomBtn['withNotificationIcon'] ?? 'no') == 'yes') { ?>sab-with-notification<?php } ?>" tabindex="-1" href="<?php if($sabsCustomBtn['actionType'] == 'link') { echo esc_attr($sabsCustomBtn['action']); } else { echo esc_attr('javascript:void(0);'); } ?>" <?php if($sabsCustomBtn['actionType'] == 'js-function') { ?>onclick="<?php echo esc_attr($sabsCustomBtn['action']); ?>"<?php } ?> style="background-color: <?php echo esc_attr($sabsCustomBtn['bgColor']); ?>; color: <?php echo esc_attr($sabsCustomBtn['color']); ?>;">
			<i class="<?php echo esc_attr($sabsCustomBtn['icon']); ?>"></i>
		</a>
	<?php
			endforeach;
		endif;
	?>
</div>

<?php endif; ?>