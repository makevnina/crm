<?php
echo $this->Html->tag(
	'h2',
	$this->action == 'create' ? 'Создание нового клиента' : 'Редактирование клиента'
);
if ($this->action == 'create') {
   echo $this->Form->create(
      'Client',
      array(
          'action' => 'create'
      )
   );
}
if ($this->action == 'edit') {
   echo $this->Form->create(
		'Client',
		array(
			'action' => 'edit',
			$client['Client']['id']
		)
   );
}
echo $this->Form->input(
	'surname',
	array(
		'label' => 'Фамилия'
	)
);
echo $this->Form->input(
	'name',
	array(
		'label' => 'Имя'
	)
);
echo $this->Form->input(
	'father',
	array(
		'label' => 'Отчество'
	)
);
if (! empty($client_statuses)) {
	$optionsHtml = '';
	$optionsHtml .= $this->Html->tag(
		'option',
		'',
		array(
			'class' => 'status',
			'value' => 0,
			'style' => 'background: #ffffff'
		)
	);
	$selected_color = '';
	foreach ($client_statuses as $status) {
		$selected = false;
		if (! empty($client)) {
			if ($client['Client']['client_status_id'] == $status['ClientStatus']['id']) {
				$selected = true;
				$selected_color = $status['ClientStatus']['color'];
			}
		}
		$optionsHtml .= $this->Html->tag(
			'option',
			$status['ClientStatus']['name'],
			array(
				'class' => 'status',
				'value' => $status['ClientStatus']['id'],
				'style' => "background: {$status['ClientStatus']['color']}",
				'selected' => $selected ? 'selected' : ''
			)
		);
	}
	$selectHtml = $this->Html->tag(
		'select',
		$optionsHtml,
		array (
			'id'=> 'status',
			'name' => 'data[Client][client_status_id]',
			'style' => "background-color:{$selected_color}"
		)
	);
	echo $this->Html->tag(
		'div',
		$this->Html->tag('label', 'Статус', array ('for' => 'status'))
		. $selectHtml
	);
}
if (! empty($companies)) {
$companiesList = array('');
	foreach ($companies as $company) {
	$companiesList[$company['Company']['id']] = $company['Company']['name'];
	}
	echo $this->Form->input(
			'company_id',
			array(
				'label' => 'Компания',
				'type' => 'select',
				'options' => $companiesList
			)
	);
}
echo $this->Html->link(
	'Создать новую компанию',
	'javascript:create_company_dialog()',
	array ('id' => 'CreateNewCompanyLink')
);
echo $this->Form->input(
	'position',
	array(
		'label' => 'Должность'
	)
);
if (! empty ($phones)) {
	$phone_input = '';	
	foreach ($phones as $phone) {
		$phone_input .= $this->Form->input(
			'phone',
			array(
				'label' => 'Телефон',
				'type' => 'text',
				'name' => "data[Phone][{$phone['Phone']['id']}]",
				'value' => $phone['Phone']['number']
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
	array('class' => 'add_phone')
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
	array('class' => 'add_email')
);
echo $this->Html->tag(
	'div',
	$email_input.$add_email_link,
	array(
		'class' => 'email_block'
	)
);
echo $this->Form->input(
	'source',
	array(
		'label' => 'Источник',
		'type' => 'select',
		'options' => $sourcesList
	)
);
echo $this->Form->input(
	'address',
	array(
		'label' => 'Адрес'
	)
);
echo $this->Form->end(
	$this->action == 'create' ? 'Создать' : 'Сохранить'
);