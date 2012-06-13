<?php
echo $this->Form->create(
	'Company',
	array(
		'action' => 'search'
	)
);
echo $this->Form->input('search', array ('label' => 'Поиск компании (Enter)'));
echo $this->Form->end();
echo '<br/>';

echo $this->Html->link(
	'Создать компанию',
	array(
		'action' => 'create'
	)
);
if (! empty($states)) {
	echo $this->Html->link(
		'Все компании',
		array(
			'action' => 'listing'
		)
	);
	echo $this->Form->create(
		'Company',
		array(
			'action' => 'listing'
		)
	);
	echo $this->Html->tag(
		'label',
		'Состояние компании:',
		array('class' => 'titleLabel')
	);
	foreach ($states as $state) {
		$companyCheckbox = $this->Form->checkbox(
			'',
			array(
				'name' => "data[{$state['State']['id']}]",
				'checked' => $company_filter[$state['State']['id']] ? 'checked' : '',
				'id' => $state['State']['id']
			)
		);
		$companyLabel = $this->Html->tag(
			'label',
			$state['State']['name'],
			array(
				'for' => $state['State']['id'],
				'style' => "background-color: {$state['State']['color']}",
				'class' => 'statusLabel'
			)
		);
		echo $this->Html->tag(
			'div',
			$companyCheckbox.$companyLabel,
			array('class' => 'filterDiv')
		);
	}
	echo $this->Form->end('Показать');
}