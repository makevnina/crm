<?php
echo $this->Html->tag(
	'h2',
	'Список проектов'
);

if (empty($projects)) {
	$createLink = $this->Html->link(
		'создайте',
		array(
			'action' => 'create'
		)
	);
	echo $this->Html->tag(
		'p',
		'Нет ни одного проекта, '.$createLink.' новый прямо сейчас!'
	);
}
else {
	$createLink = $this->Html->link(
		'Создать новый проект',
		array(
			'action' => 'create'
		)
	);
	echo $this->Html->tag(
		'p',
		$createLink
	);
	foreach ($projects as $project) {
		$projectNameLink = $this->Html->link(
			$project['Project']['name'],
			array(
				'action' => 'view',
				$project['Project']['id']
			)
		);
		echo $this->Html->tag(
			'h3',
			$projectNameLink
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
	}
}