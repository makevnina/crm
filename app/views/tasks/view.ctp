<?php
echo $this->Html->link(
	'К списку задач',
	array(
		'action' => 'listing'
	)
);
echo $this->Html->tag(
	'h2',
	$task['Task']['name']
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
	array(
		'action' => 'delete',
		$task['Task']['id']
	)
);
echo $this->Html->tag(
	'div',
	$editLink.', '.$deleteLink	
);
echo $this->Html->tag(
	'span',
	$task['TaskState']['name'],
	array(
		'class' => 'status',
		'style' => "background: {$task['TaskState']['color']}"
	)
).' '.
$this->Html->tag(
	'span',
	$task['Task']['deadline_date'].' '.$task['Task']['deadline_time']
);
echo $this->Html->tag(
	'dl',
	$this->Html->tag(
		'dt',
		'Ответственный'
	).$this->Html->tag(
		'dd',
		'<ФИО менеджера>'
	)
);
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
			'style' => 'border:1px solid #ccc'
		)
	);
}
echo $this->Html->tag(
	'b',
	'<Комментарии>'
);