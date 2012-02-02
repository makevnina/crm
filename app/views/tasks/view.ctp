<?php
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
$tableCells = array(
	'<статус задачи>',
	$task['Task']['deadline_date'].' '.$task['Task']['deadline_time']	
);
echo $this->Html->tag(
	'table',
	$this->Html->tableCells($tableCells),
	array(
		'border' => 0
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
	)
);
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
	'dl',
	$this->Html->tag(
		'dt',
		'Клиент'
	).$this->Html->tag(
		'dd',
		'<ФИО клиента>'
	)
);
echo $this->Html->tag(
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
	'b',
	'<Комментарии>'
);