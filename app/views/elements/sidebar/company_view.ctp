<?php
echo $this->Html->link(
	'К списку компаний',
	array(
		'action' => 'listing'
	)
);
echo $this->Html->link(
	'Данные компании',
	array(
		'action' => 'view',
		$company['Company']['id']
	)
);
echo $this->Html->link(
	'Контактные лица компании',
	array(
		'action' => 'company_clients',
		$company['Company']['id']
	)
);
echo $this->Html->link(
	'Проекты компании',
	array(
		'action' => 'company_projects',
		$company['Company']['id']
	)
);
echo $this->Html->link(
	'Задачи по контактным лицам компании',
	array(
		'action' => 'company_tasks',
		$company['Company']['id']
	)
);
