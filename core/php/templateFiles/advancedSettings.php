
<div class="innerFirstDevBox"  >
	<div class="devBoxTitle">
		<b>Advanced</b> 
	</div>
	<div class="devBoxContent">
		<ul class="settingsUl">
		<?php if(!empty($cachedStatusMainObject)):?>
			<li>
				<button class="mainLinkClass" onclick="clearCache();" >Clear Cache</button>
			</li>
		<?php else: ?>
			<li>
				<p>Cache is empty</p>
			</li>
		<?php endif; ?>
		</ul>
	</div>
</div>
