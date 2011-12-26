<?php
if ($this->action == 'create') {
			$title = $this->Html->tag(
						'h2',
						'Добавление нового клиента'
			);
			$submit = 'Добавить';
}
else {
			$title = $this->Html->tag(
						'h2',
      'Редактирование клиента'
   );
   $submit = 'Сохранить';
}

echo $title;

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
               $company['Company']['id']
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
echo $this->Form->input(
        'address',
        array(
            'label' => 'Адрес'
        )
);
echo $this->Form->end($submit);