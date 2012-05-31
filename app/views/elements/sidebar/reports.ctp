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
	if ($userOK) {
		if (! empty($users)) {
			echo $this->Form->create(
				'Report',
				array('action' => 'sales_funnel')
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
}
