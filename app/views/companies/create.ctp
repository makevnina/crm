<?php
if ($this->action == 'create') {
   $title = $this->Html->tag(
           'h2',
           'Создание новой компании'
   );
   $submit = 'Добавить';
}
if ($this->action == 'edit') {
   $title = $this->Html->tag(
           'h2',
           'Редактирование компании'
   );
   $submit = 'Сохранить';
}
echo $title;

if ($this->action == 'create') {
   $this->Form->create(
           'Company',
           array(
               'action' => 'create'
           )
   );
}
if ($this->action == 'edit') {
   $this->Form->create(
           'Company',
           array(
               'action' => 'edit'
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
echo $this->Form->input(
        'address',
        array(
            'label' => 'Адрес'
        )
);
echo $this->Form->end($submit);