<?php
	$sabsOptions = get_option('sabs');
	$sabsEnabled = (!empty($sabsOptions) && $sabsOptions['enabled'] == 'yes');
	$sabsButtons = $sabsOptions['buttons'] ?? [];

	if($sabsEnabled && !empty($sabsButtons)):
?>

<div class="sabs-container">
	<?php if(isset($sabsButtons['whatsApp'])): ?>
		<a href="https://wa.me/<?php _e(str_replace(' ', '', $sabsButtons['whatsApp'])); ?>" class="fab sab-whatsapp sab-with-notification" tabindex="-1">
			<i class="icofont-whatsapp"></i>
		</a>
	<?php endif; ?>
	<?php if(isset($sabsButtons['phone'])): ?>
		<a href="tel:<?php _e($sabsButtons['phone']); ?>" class="fab sab-phone" tabindex="-1">
			<i class="icofont-phone"></i>
		</a>
	<?php endif; ?>
	<?php if(isset($sabsButtons['email'])): ?>
		<a href="tel:<?php _e($sabsButtons['email']); ?>" class="fab sab-email" tabindex="-1">
			<i class="icofont-email"></i>
		</a>
	<?php endif; ?>
</div>

<?php endif; ?>