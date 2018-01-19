<style type="text/css" media="screen">
	.language-menu{
		display: inline-block;
		@include transition(.2s);
	}
</style>

<div class="language-menu">
	<?php if ( function_exists( 'icl_get_languages' ) ) : $languages = icl_get_languages('skip_missing=0'); ?>
		<!-- get and delete current language from array -->

		<!-- build list for remaining languages -->
		<?php if ($languages): ?>
			<ul id="lang-select">
				<?php foreach ($languages as $key => $l): if($l['active']): ?>
					<span class="lang-text short-code"><?= $l['code']; ?></span>

					<?php unset($languages[$key]); ?>
				<?php continue; endif; endforeach; ?>
				<?php foreach ($languages as $l): ?>
					<li class="language-item">
						<a href="<?= $l['url']; ?>">
							<span class="short-code"><?= $l['code']; ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	<?php endif; ?>
</div>





<!-- OR WITHOUT CHANGING ORDER-->



<style type="text/css" media="screen">
	.language-menu{
		display: inline-block;
		.lang-text{
			color: $green;
			padding: 0;
			display: inline-block;
		}
		#lang-select, #lang-select li{
			display: inline-block;
		    padding: 0 1em;
		}
		#lang-select{
			margin: 1em 0;
		}
	}
</style>

<div class="language-menu">
	<?php if ( function_exists( 'icl_get_languages' ) ) : $languages = icl_get_languages('skip_missing=0'); ?>
		<!-- get and delete current language from array -->

		<!-- build list for remaining languages -->
		<?php if ($languages): ?>
			<ul id="lang-select">

				<?php foreach ($languages as $l): ?>
					<li class="language-item">
						<?php if($l['active']): ?>
							<?php $class = 'lang-text short-code' ?>
						<?php else: ?>
							<?php $class = 'short-code' ?>
						<?php endif; ?>
						<a href="<?= $l['url']; ?>">
							<span class="<?php echo $class ?>"><?= $l['code']; ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	<?php endif; ?>
</div>