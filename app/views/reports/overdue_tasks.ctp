<?php
echo $this->Html->tag(
	'h2',
	'Просроченные задачи'
);
if (empty($tasks)) {
	echo 'Нет задач для отчета.';
}
else {
	$taskByUser = array();
	foreach ($tasks as $task) {
		$key = $task['User']['surname'].' '.$task['User']['name'];
		if (empty($taskByUser[$key])) {
			$taskByUser[$key] = 1;
		}
		else {
			$taskByUser[$key] += 1;
		}
	}
	$tableHeaders = array('Пользователь', 'Кол-во просроченных задач');
	$tableCells = array();
	foreach ($taskByUser as $key => $count) {
		$user = $key;
		$padding = $count*10;
		if ($padding > 85) {
			$padding = 85;
		}
		$task_count = $this->Html->tag(
			'span',
			$count,
			array(
				'class' => 'overdueTaskCount',
				'style' => "padding: 5px {$padding}px 5px {$padding}px"
			)
		);
		$tableCells[] = array($user,$task_count);
	}
	echo $this->Html->tag(
		'table',
		$this->Html->tableHeaders($tableHeaders).$this->Html->tableCells($tableCells),
		array('class' => 'overdueTask')
	);
}