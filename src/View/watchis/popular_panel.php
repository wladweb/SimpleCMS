<?php
/*
    use SimpleCMS\Application\Controller\SingleController;
    
    $is_single = $this instanceof SingleController;
    $post = $this->post;
    */
?>
<span class="pop">
	<div class="pop-inner">
		<?=$this->post['popular']?>
	</div>
	<?php if(isset($this->vote_panel) and $this->user) :?>
	<div class="vote">
		<a href="/single/popular/pid/<?=$this->post['id']?>/pop/p" class="plus">+</a>
		<a href="/single/popular/pid/<?=$this->post['id']?>/pop/m" class="minus">-</a>
	</div>
	<?php endif; ?>	
</span>