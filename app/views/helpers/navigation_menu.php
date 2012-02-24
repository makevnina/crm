<?php

class NavigationMenuHelper extends AppHelper {
	
	public $helpers = array ('Html');
	
	public $items = array (
		array(
			'title' => 'Задачи',
			'link' => array('controller' => 'tasks', 'action' => 'listing')
		),
		array (
			'title' => 'Проекты',
			'link' => array ('controller' => 'projects', 'action' => 'listing')
		),
		array (
			'title' => 'Клиенты',
			'link' => array ('controller' => 'clients', 'action' => 'listing')
		),
		array (
			'title' => 'Компании',
			'link' => array ('controller' => 'companies', 'action' => 'listing')
		),
		array(
			'title' => 'Настройки',
			'link' => array('controller' => 'settings')
		)
	);
	
	public function render() {
		return $this->renderGroup($this->items, 'main');
	}
	
	public function renderGroup($items, $class = '') {
		$resultHtml = '';
		foreach ($items as $item) {
			$options = array ('class' => $class);
			if ($item['link']['controller'] == $this->params['controller']) {
				$options['class'] .= ' active';
			}
			$resultHtml .= $this->Html->tag(
				'li',
				$this->Html->link($item['title'], $item['link']),
				$options
			);
		}
		return $this->Html->tag(
			'ul',
			$resultHtml,
			array ('class' => $class, 'escape' => false)
		);
	}
	
}