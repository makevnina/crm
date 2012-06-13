<?php
	echo $this->Html->tag(
		'h2',
		'Поиск компаний по запросу "' . $request . '"' 
	);
?>
<? if(empty($companies)): ?>
	<p>К сожалению, по данному запросу ничего не найдено.</p>
<? else: ?>
	<ul>
		<? foreach($companies as $company): ?>
			<li>
				<?= $this->Html->link($company['Company']['name'], array('controller' => 'companies', 'action' => 'view', $company['Company']['id'])); ?>
			</li>
   	<? endforeach; ?>
	</ul>
<? endif; ?>