<?php
	echo $this->Html->tag(
		'h2',
		'Поиск проектов по запросу "' . $request . '"' 
	);
?>
<? if(empty($projects)): ?>
	<p>К сожалению, по данному запросу ничего не найдено.</p>
<? else: ?>
	<ul>
		<? foreach($projects as $project): ?>
			<li>
				<?= $this->Html->link($project['Project']['name'], array('controller' => 'projects', 'action' => 'view', $project['Project']['id'])); ?>
			</li>
   	<? endforeach; ?>
	</ul>
<? endif; ?>