<?php
	echo $this->Html->tag(
		'h2',
		'Поиск задач по запросу "' . $request . '"' 
	);
?>
<? if(empty($tasks)): ?>
	<p>К сожалению, по данному запросу ничего не найдено.</p>
<? else: ?>
	<ul>
		<? foreach($tasks as $task): ?>
			<li>
				<?= $this->Html->link($task['Task']['name'], array('controller' => 'tasks', 'action' => 'view', $task['Task']['id'])); ?>
			</li>
   	<? endforeach; ?>
	</ul>
<? endif; ?>