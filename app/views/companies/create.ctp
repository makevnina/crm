<?php
echo $this->Html->tag(
	'h2',
	$this->action == 'create' ? 'Создание новой компании' : 'Редактирование компании'
);

if ($this->action == 'create') {
	echo $this->Form->create(
		'Company',
		array(
			'action' => 'create'
		)
	);
}
if ($this->action == 'edit') {
	echo $this->Form->create(
		'Company',
		array(
			'action' => 'edit',
			'id' => 'create_company_form'
		)
	);
}
echo $this->Form->input(
	'name',
	array(
		'label' => 'Название'
	)
);
echo $this->Form->input(
	'activity',
	array(
		'label' => 'Сфера деятельности'
	)
);
if (! empty($phones)) {
	$phone_input = '';
	foreach ($phones as $phone) {
		$phone_input .= $this->Form->input(
			'phone',
			array(
				'label' => 'Телефон',
				'name' => "data[Phone][{$phone['Phone']['id']}]",
				'value' => $phone['Phone']['number'],
				'type' => 'text'
			)
		);
	}
}
else {
	$phone_input = $this->Form->input(
		'phone',
		array(
			'label' => 'Телефон',
			'name' => 'data[Phone][new][]',
			'type' => 'text'
		)
	);
}
$add_phone_link = $this->Html->link(
	'Добавить телефон',
	'javascript:void(0)',
	array (
		'class' => 'add_field'
	)
);
echo $this->Html->tag(
	'div',
	$phone_input.$add_phone_link,
	array(
		'class' => 'phone_block'
	)
);
if (! empty($emails)) {
	$email_input = '';
	foreach ($emails as $email) {
		$email_input .= $this->Form->input(
			'email',
			array(
				'label' => 'E-mail',
				'name' => "data[Email][{$email['Email']['id']}]",
				'value' => $email['Email']['address'],
				'type' => 'text'
			)
		);
	}
}
else {
	$email_input = $this->Form->input(
		'email',
		array(
			'label' => 'E-mail',
			'name' => 'data[Email][new][]',
			'type' => 'text'
		)
	);
}
$add_email_link = $this->Html->link(
	'Добавить e-mail',
	'javascript:void(0)',
	array(
		'class' => 'add_field'
	)
);
echo $this->Html->tag(
	'div',
	$email_input.$add_email_link,
	array(
		'class' => 'email_block'
	)
);
echo $this->Form->input(
	'address',
	array(
		'label' => 'Адрес'
	)
);
$optionsHtml = '';
if (! empty($company)) {
	if (! empty($company['Client'])) {
		$thisCompanyClientList = array();
		foreach ($company['Client'] as $client) {
			$optionsHtml .=$this->Html->tag(
				'option',
				$client['surname'].' '.$client['name'].' '.$client['father'],
				array(
					'value' => $client['id'],
					'selected' => 'selected'
				)
			);
		}
	}
}
if (! empty($clients)) {
	$clientList = array();
	foreach ($clients as $client) {
		$clientList[$client['Client']['id']] = $client['Client']['surname']
			.' '.$client['Client']['name'].' '.$client['Client']['father'];
		$optionsHtml .= $this->Html->tag(
			'option',
			$client['Client']['surname']
			.' '.$client['Client']['name'].' '.$client['Client']['father'],
			array(
				'value' => $client['Client']['id']
			)
		);
	}
}
if (! empty($optionsHtml)) {
	$clientSelect = $this->Html->tag(
		'select',
		$optionsHtml,
		array(
			'name' => 'data[Client][]',
			'id' => 'clientSelect',
			'multiple' => true
		)
	);
	echo $this->Html->tag(
		'div',
		$this->Html->tag(
			'label',
			'Контактные лица',
			array('for' => 'clientSelect')
		)
		. $clientSelect
	);
}
echo $this->Form->end($this->action == 'create' ? 'Создать' : 'Сохранить');