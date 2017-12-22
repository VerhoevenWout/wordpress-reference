	
	<?php if(strpos($website_url, "http://") == false):?>
		<a href="http://<?= $website_url ?>" data-log="true" data-type="visit" data-post="<?=$post->ID?>" target="_blank"><?= _e('More information on the website', 'captions') ?></a>
	<?php else:?>
		<a href="<?= $website_url ?>" data-log="true" data-type="visit" data-post="<?=$post->ID?>" target="_blank"><?= _e('More information on the website', 'captions') ?></a>
	<?php endif?>