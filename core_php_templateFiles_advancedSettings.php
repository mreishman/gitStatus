
<div class="innerFirstDevBox"  >
	<div class="devBoxTitle">
		<b>Advanced</b>
	</div>
	<div class="devBoxContent">
	<?php if(!empty($cachedStatusMainObject)):?>
		<button class="mainLinkClass" onclick="clearCache();" >Clear Cache</button>
	<?php else: ?>
		<p>Cache is empty</p>
	<?php endif; ?>
	</div>
</div>
