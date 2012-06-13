<?php
if ($this->params['controller'] == 'tasks') {
	$artifact_type = 'задач';
}
if ($this->params['controller'] == 'projects') {
	$artifact_type = 'проектов';
}
if ($this->params['controller'] == 'companies') {
	$artifact_type = 'компаний';
}
if ($this->params['controller'] == 'clients') {
	$artifact_type = 'клиентов';
}
echo $this->Html->link(
	'Вернуться к списку ' . $artifact_type,
	array(
		'controller' => $this->params['controller'],
		'action' => 'listing'
	)
);
