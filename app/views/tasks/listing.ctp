<?php
echo $this->Html->tag(
	'h2',
	'Задачи'
);

if (empty($tasks)) {
	$createLink = $this->Html->link(
		'Создайте',
		array(
			'action' => 'create'
		)
	);
	echo 'Еще не создано ни одной задачи. '.$createLink.' новую прямо сейчас!';
}
else {
	$createLink = $this->Html->link(
		'Создать новую задачу',
		array(
			'action' => 'create'
		)
	);
	echo $createLink;
	foreach ($tasks as $task) {
		echo $this->Html->tag(
			'h3',
			$this->Html->link(
				$task['Task']['name'],
				array(
					'action' => 'view',
					$task['Task']['id']
				)
			)
		);
		$tableCells = array(
			'статус задачи',
			$task['Task']['deadline_date'].' '.$task['Task']['deadline_time']
		);
		echo $this->Html->tag(
			'table',
			$this->Html->tableCells($tableCells),
			array(
				'border' => 0
			)
		);
		if (! empty($task['Task']['description'])){
			$showDetailsLink = $this->Html->link(
				'+',
				'javascript:void(0)',
				array(
					'id' => 'toggle_description',
					'onclick' => "return toggle_details({$task['Task']['id']})"
				)
			);
			echo $this->Html->tag(
				'div',
				$showDetailsLink
			);
			$user = $this->Html->tag(
				'dl',
				$this->Html->tag(
					'dt',
					'Ответственный'
				).$this->Html->tag(
					'dd',
					'<ФИО>'
				)
			);
			$description = $this->Html->tag(
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
					'style' => 'border: 1px solid #ccc'
				)
			);
			$client = $this->Html->tag(
				'dl',
				$this->Html->tag(
					'dt',
					'Клиент'
				).$this->Html->tag(
					'dd',
					'<ФИО клиента или Название компании>'
				)
			);
			$project = $this->Html->tag(
				'dl',
				$this->Html->tag(
					'dt',
					'Проект'
				).$this->Html->tag(
					'dd',
					'<Название проекта>'
				)
			);
			echo $this->Html->tag(
				'div',
				$user.$description.$client.$project,
				array(
					'class' => "details_block block{$task['Task']['id']}"
				)
			);
		}
		
	}
}