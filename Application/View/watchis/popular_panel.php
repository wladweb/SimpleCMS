<?php
    use SimpleCMS\Application\Controller\SingleController;
    
    $is_single = $this instanceof SingleController;
    $post = $this->post;
    
?>
<span class="pop">
	<div class="pop-inner">
		<?=$post['popular']?>
	</div>
	<?php if($is_single and $this->user) :?>
	<div class="vote">
		<a href="/single/popular/pid/<?=$post['id']?>/pop/p" class="plus">+</a>
		<a href="/single/popular/pid/<?=$post['id']?>/pop/m" class="minus">-</a>
	</div>
	<?php endif; ?>	
</span>