<?php
if (! empty($project_statuses)) {
	echo $this->Form->create(
		'ProjectStatus',
		array('url' => array(
			'controller' => 'reports',
			'action' => 'stages',
			''
		))
	);
	$title = $this->Html->tag(
		'div',
		$this->Html->tag(
			'b',
			'Этапы проекта'
		),
		array('style' => 'margin-bottom: 10px')
	);
	$li_statuses = '';
	foreach ($project_statuses as $status) {
		$li_statuses .= $this->Html->tag(
			'li',
			$status['ProjectStatus']['name'],
			array(
				'id' => $status['ProjectStatus']['id'],
				'class' => 'ui-state-default',
				'style' => "background: {$status['ProjectStatus']['color']}"
			)
		);
	}
	$ul_statuses = $this->Html->tag(
		'ul',
		$li_statuses,
		array('id' => 'sortable')
	);
	echo $this->Html->tag(
		'div',
		$title.$ul_statuses
	);
	echo $this->Form->end('Сохранить');
}
