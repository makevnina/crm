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
echo $this->Form->input(
	'position',
	array(
		'label' => 'Должность'
	)
);

if (! empty ($client['Phone'])) {
	$phone_input = '';
	foreach ($client['Phone'] as $phone) {
		$phone_input .= $this->Form->input(
			'phone',
			array(
				'label' => 'Телефон',
				'name' => "data[Phone][{$phone['id']}]",
				'value' => $phone['number']
			)
		);
	}
}
else {
	$phone_input = $this->Form->input(
		'phone',
		array(
			'label' => 'Телефон',
			'name' => 'data[Phone][new][]'
		)
	);
}

$add_phone_link = $this->Html->link(
	'Добавить телефон',
	'#',
	array(
		'onclick' => 'return add_phone();'
	)
);

echo $this->Html->tag(
	'div',
	$phone_input.$add_phone_link,
	array(
		'class' => 'phone_block'
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