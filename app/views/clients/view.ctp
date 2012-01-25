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
if (! empty($phones)) {
	$phone_list = '';
	foreach ($phones as $phone) {
		if ($phone_list !== '') {
			$phone_list .= ', ';
		}
		$phone_list .= $phone['Phone']['number'];
	}
	echo $this->Html->tag(
		'dl',
		$this->Html->tag(
		'dt',
		'Телефон: ').
		$this->Html->tag(
			'dd',
			$phone_list
		)
	);
}
if (! empty($emails)) {
	$email_list = '';
	foreach ($emails as $email) {
		if ($email_list !== '') {
			$email_list .= ', ';
		}
		$email_list .= $email['Email']['address'];
	}
	echo $this->Html->tag(
		'dl',
		$this->Html->tag(
		'dt',
		'E-mail: ').
		$this->Html->tag(
			'dd',
			$email_list
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