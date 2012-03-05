<?php
$clientNameLink = $this->Html->link(
	$client['Client']['surname'].' '.$client['Client']['name'].' '
	.$client['Client']['father'],
	array(
		'action' => 'view',
		$client['Client']['id']
	)
);
echo $this->Html->tag(
	'h2',
	'Клиент: '.$clientNameLink	
);
if (empty($tasks)) {
	echo 'Нет задач, связанных с клиентом.';
}
else {
	echo $this->Html->tag(
		'h3',
		'Задачи, связанные с клиентом:'
	);
	foreach ($tasks as $task) {
		$taskNameLink = $this->Html->tag(
			'h4',
			$this->Html->link(
				$task['Task']['name'],
				array(
					'controller' => 'tasks',
					'action' => 'view',
					$task['Task']['id']
				)
			),
			array('style' => 'display: inline')
		);
		$taskStatus = $this->Html->tag(
			'span',
			$task['TaskStatus']['name'],
			array(
				'class' => 'status',
				'style' => "background: {$task['TaskStatus']['color']}"
			)
		);
		$taskDeadline = $this->Html->tag(
			'span',
			$task['Task']['deadline_date'].' '.$task['Task']['deadline_time'],
			array(
				'class' => 'taskDeadline'
			)
		);
		echo $this->Html->tag(
			'div',
			$taskNameLink.' '.$taskStatus.' '.$taskDeadline
		);
		echo $this->Html->link(
			'+',
			'javascript:void(0)',
			array(
				'id' => 'toggle_description',
				'onclick' => "return toggle_details({$task['Task']['id']})",
				'style' => 'display: block'
			)
		);
		echo $this->Html->tag(
			'dl',
			$this->Html->tag(
				'dt',
				'Ответственный'
			).$this->Html->tag(
				'dd',
				'<ФИО менеджера>'
			),
			array('class' => "details_block block{$task['Task']['id']}")
		);
		if (!empty($task['Project']['name'])) {
			$projectLink = $this->Html->link(
				$task['Project']['name'],
				array(
					'controller' => 'projects',
					'action' => 'view',
					$task['Project']['id']
				)
			);
			echo $this->Html->tag(
				'dl',
				$this->Html->tag(
					'dt',
					'Проект'
				).$this->Html->tag(
					'dd',
					$projectLink
				),
			array('class' => "details_block block{$task['Task']['id']}")
			);
		}
		if (!empty ($task['Task']['description'])) {
			echo $this->Html->tag(
				'div',
				$this->Html->tag(
					'div',
					$this->Html->tag(
						'b',
						'Описание'
					)
				).$this->Html->tag(
					'div',
					$task['Task']['description']
				),
				array(
					'style' => 'border:1px solid #ccc; width:55%',
					'class' => "details_block block{$task['Task']['id']}"
				)
			);
		}
		echo $this->Html->tag(
			'b',
			'<Комментарии>',
			array('class' => "details_block block{$task['Task']['id']}")
		);
	}
}