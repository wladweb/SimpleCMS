<?php
    use SimpleCMS\Application\Controller\SingleController;
?>
<span class="pop">
	<div class="pop-inner">
		<?=$this->post['popular']?>
	</div>
	<?php if(($this instanceof SingleController) and $this->user) :?>
	<div class="vote">
		<a href="/single/popular/pid/<?=$this->post['id']?>/pop/p" class="plus">+</a>
		<a href="/single/popular/pid/<?=$this->post['id']?>/pop/m" class="minus">-</a>
	</div>
	<?php endif; ?>	
</span>