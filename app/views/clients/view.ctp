<?php
$clientName = $this->Html->tag(
    'h2',
    $client['Client']['surname'].' '.$client['Client']['name'].' '.$client['Client']['father'],
	array(
		'style' => 'display: inline'
	)
);
if ($client['Client']['client_status_id'] <> 0) {
	$clientStatus = $this->Html->tag(
		'span',
		$client['ClientStatus']['name'],
		array(
			'class' => 'status',
			'style' => "background:{$client['ClientStatus']['color']}"
		)
	);
}
else {
	$clientStatus = '';
}
echo $this->Html->tag(
	'div',
	$clientName.' '.$clientStatus
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
	'javascript: void(0)',
	array(
		'onclick' => "return deleteClient({$client['Client']['id']});"
	)
);
echo $this->Html->tag(
        'p',
        '['.$editLink.', '.$deleteLink.']'
);
if ($client['Company']['id'] <> 0) {
   echo $this->Html->tag(
		'h3',
		$this->Html->link(
         'Компания "'.$client['Company']['name'].'"',
         array(
             'controller' => 'companies',
             'action' => 'view',
             $client['Company']['id']
         )
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
if (! empty($client['Client']['address'])) {
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