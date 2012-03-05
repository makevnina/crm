<?php
echo $this->Html->link(
	'Создать проект',
	array(
		'action' => 'create'
	)
);

if (! empty($statuses)) {
	echo $this->Html->link(
		'Все проекты',
		array(
			'action' => 'listing'
		)
	);
	echo $this->Form->create(
		'Project',
		array(
			'action' => 'listing'
		)
	);
	foreach ($statuses as $status) {
		echo $this->Form->checkbox(
			'',
			array(
				'name' => "data[{$status['ProjectStatus']['id']}]",
				'checked' => $project_filter[$status['ProjectStatus']['id']] ? 'checked' : '',
				'id' => $status['ProjectStatus']['id']
			)
		);
		echo $this->Html->tag(
			'label',
			$status['ProjectStatus']['name'],
			array(
				'for' => $status['ProjectStatus']['id']
			)
		);
	}
	echo $this->Form->end('Показать');
}