<?php
echo $this->Html->link(
	'Воронка продаж',
	array('action' => 'sales_funnel')
);
if ($this->action == 'sales_funnel') {
	echo $this->Html->link(
		'Этапы проекта',
		array(
			'action' => 'stages',
			''
		)
	);
	echo $this->Form->create(
		'Report',
		array('action' => 'sales_funnel')
	);
	$periodArray = array(
		'all_time' => 'За весь период',
		'this_year' => 'За год',
		'this_month' => 'За месяц',
	);
	echo $this->Form->input(
		'period',
		array(
			'label' => 'Период',
			'type' => 'select',
			'options' => $periodArray
		)
	);
	if ($userOK) {
		if (! empty($users)) {
			$usersList = array('Все пользователи');
			foreach ($users as $user) {
				$usersList[$user['User']['id']] = $user['User']['surname'].' '.$user['User']['name'];
			}
			echo $this->Form->input(
				'user_id',
				array(
					'label' => 'Пользователь',
					'type' => 'select',
					'options' => $usersList
				)
			);
		}
	}
	echo $this->Form->end('Показать');
}
if (($isAdmin) OR ($isAnalyst)) {
	echo  $this->Html->link(
		'Просроченные задачи',
		array('action' => 'overdue_tasks')
	);
	echo $this->Html->link(
		'Текущие проекты',
		array('action' => 'present_projects')
	);
	if ($this->action == 'present_projects') {
		if (! empty($users)) {
			echo $this->Form->create(
				'Report',
				array('action' => 'present_projects')
			);
			$usersList = array('Все пользователи');
			foreach ($users as $user) {
				$usersList[$user['User']['id']] = $user['User']['surname'].' '.$user['User']['name'];
			}
			echo $this->Form->input(
				'user_id',
				array(
					'label' => 'Пользователь',
					'type' => 'select',
					'options' => $usersList
				)
			);
			echo $this->Form->end('Показать');
		}
	}
	echo $this->Html->link(
		'Источники клиентов',
		array('controller' => 'reports', 'action' => 'client_sources')
	);
}