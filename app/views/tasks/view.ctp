<?php
if (! empty($task)) {
	$taskType = $this->Html->tag(
		'span',
		$task['Task']['type'],
		array('class' => 'taskType')
	);
	$taskName = $this->Html->tag(
		'h2',
		$task['Task']['name'],
		array(
			'style' => 'display: inline'
		)
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
	$editLink = $this->Html->link(
		'редактировать',
		array(
			'action' => 'edit',
			$task['Task']['id']
		)
	);
	$deleteLink = $this->Html->link(
		'удалить',
		'javascript: void(0)',
		array(
			'onclick' => "return deleteTask({$task['Task']['id']})"
		)
	);
	$editBar = $this->Html->tag(
		'span',
		'['.$editLink.', '.$deleteLink.']',
		array('class' => 'editBar')
	);
	echo $this->Html->tag(
		'div',
		$taskName.' '.$editBar
	);
	echo $this->Html->tag(
		'div',
		$taskType.' '.$taskStatus.' '.$taskDeadline,
		array('class' => 'statusBar')
	);

	if (! empty($user)) {
		echo $this->Html->tag(
			'div',
			'Добавлена пользователем '
			. $this->Html->tag(
			'b',
			$user['User']['surname'].' '. $user['User']['name']
			),
			array('class' => 'taskCreator')
		);
	}
	if ($task['Task']['user_id'] <> 0) {
		echo $this->Html->tag(
			'dl',
			$this->Html->tag(
				'dt',
				'Ответственный'
			).$this->Html->tag(
				'dd',
				$task['User']['surname'].' '.$task['User']['name']
			)
		);
	}
	if (! empty($task['Client']['name'])) {
		$clientLink = $this->Html->link(
			$task['Client']['surname'].' '.$task['Client']['name'].' '.$task['Client']['father'],
			array(
				'controller' => 'clients',
				'action' => 'view',
				$task['Client']['id']
			)
		);
		$companyLink = '';
		if ($task['Client']['company_id'] !== 0) {
			foreach ($companies as $company) {
				if ($company['Company']['id'] == $task['Client']['company_id']) {
					$companyLink = ' ('.$this->Html->link(
						'компания "'.$company['Company']['name'].'"',
						array(
							'controller' => 'companies',
							'action' => 'view',
							$company['Company']['id']
						)
					).')';
				}
			}
		}
		echo $this->Html->tag(
			'dl',
			$this->Html->tag(
				'dt',
				'Клиент'
			).$this->Html->tag(
				'dd',
				$clientLink.$companyLink
			)
		);
	}
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
			)
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
				'style' => 'border:1px solid #ccc; width:55%'
			)
		);
	}
	echo $this->Html->tag(
		'b',
		'<Комментарии>'
	);
}
else {
	echo 'Ошибка доступа.';
}