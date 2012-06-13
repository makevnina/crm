<?php
	echo $this->Html->tag(
		'h2',
		'Поиск клиентов по запросу "' . $request . '"' 
	);
?>
<? if(empty($clients)): ?>
	<p>К сожалению, по данному запросу ничего не найдено.</p>
<? else: ?>
	<ul>
		<? foreach($clients as $client): ?>
			<li>
				<?= $this->Html->link(
					$client['Client']['surname'].' '.$client['Client']['name'].' '.$client['Client']['father'],
					array('controller' => 'clients', 'action' => 'view', $client['Client']['id']));
				?>
			</li>
   	<? endforeach; ?>
	</ul>
<? endif; ?>