<?php
echo $this->Html->link(
        'К списку клиентов',
        array(
            'action' => 'listing'
        )
); 
echo $this->Html->tag(
    'h2',
    $client['Client']['surname'].' '.$client['Client']['name'].' '.$client['Client']['father']
);
$editLink = $this->Html->link(
        'редактировать',
        array(
            'action' => 'edit',
            $client['Client']['id']
        )
);
$deleteLink = $this->Html->link(
        'удалить',
        array(
            'action' => 'delete',
            $client['Client']['id']
        )
);
echo $this->Html->tag(
        'p',
        '['.$editLink.', '.$deleteLink.']'
);
if ($client['Company']['id'] <> 0) {
   echo $this->Html->link(
         'Компания '.$client['Company']['name'],
         array(
             'controller' => 'companies',
             'action' => 'view',
             $client['Company']['id']
         )
   );
}
if ($client['Client']['position'] <> '') {
   echo $this->Html->tag(
		'dl',
		$this->Html->tag(
		'dt',
		'Должность: ').
		$this->Html->tag(
			'dd',
			$client['Client']['position']
		)
	);
}
if ($client['Client']['address'] <> '') {
   echo $this->Html->tag(
		'dl',
		$this->Html->tag(
		'dt',
		'Адрес: ').
		$this->Html->tag(
			'dd',
			$client['Client']['address']
		)
	);
}