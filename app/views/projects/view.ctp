<?php
echo $this->Html->link(
	'К списку проектов',
	array(
		'action' => 'listing'
	)
);
echo $this->Html->tag(
	'h2',
	$project['Project']['name']
);
$editLink = $this->Html->link(
	'редактировать',
	array(
		'action' => 'edit',
		$project['Project']['id']
	)
);
$deleteLink = $this->Html->link(
	'удалить',
	array(
		'action' => 'delete',
		$project['Project']['id']
	)
);
echo $this->Html->tag(
	'p',
	'['.$editLink.', '.$deleteLink.']'
);
if (! empty($project['Project']['description'])) {
	echo $this->Html->tag(
		'dl',
		$this->Html->tag(
		'dt',
		'Описание: ').
		$this->Html->tag(
			'dd',
			$project['Project']['description']
		)
	);
}
if ($project['Project']['start_date'] <> '0000-00-00') {
	echo $this->Html->tag(
		'dl',
		$this->Html->tag(
		'dt',
		'Дата начала: ').
		$this->Html->tag(
			'dd',
			$project['Project']['start_date']
		)
	);
}
if ($project['Project']['plan_date'] <> '0000-00-00') {
	echo $this->Html->tag(
		'dl',
		$this->Html->tag(
		'dt',
		'Дата планируемого окончания: ').
		$this->Html->tag(
			'dd',
			$project['Project']['plan_date']
		)
	);
}
if ($project['Project']['fact_date'] <> '0000-00-00') {
	echo $this->Html->tag(
		'dl',
		$this->Html->tag(
		'dt',
		'Дата фактического окончания: ').
		$this->Html->tag(
			'dd',
			$project['Project']['fact_date']
		)
	);
}