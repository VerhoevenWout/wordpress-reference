<div class="language-menu">
	<?php if ( function_exists( 'icl_get_languages' ) ) : $languages = icl_get_languages('skip_missing=0'); ?>
		<!-- get and delete current language from array -->
		<div id="current-lang">
			<?php foreach ($languages as $key => $l): if($l['active']): ?>
				<span class="lang-text short-code"><?= $l['code']; ?></span>
				<span class="lang-text native-name"><?= $l['native_name']; ?></span>

				<?php unset($languages[$key]); ?>
			<?php continue; endif; endforeach; ?>
		</div>

		<!-- build list for remaining languages -->
		<?php if ($languages): ?>
			<ul id="lang-select">
				<?php foreach ($languages as $l): ?>
					<li class="language-item">
						<a href="<?= $l['url']; ?>">
							<span class="short-code"><?= $l['code']; ?></span>
							<span class="native-name"><?= $l['native_name']; ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	<?php endif; ?>
</div>