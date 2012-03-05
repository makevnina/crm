<?php
echo $this->Html->tag(
         'h2',
         'Компания "'.$company['Company']['name'].'"'
);
$editLink = $this->Html->link(
        'редактировать',
        array(
            'action' => 'edit',
            $company['Company']['id']
        )
);
$deleteLink = $this->Html->link(
        'удалить',
        array(
            'action' => 'delete',
            $company['Company']['id']
        )
);
echo $this->Html->tag(
        'p',
        '['.$editLink.', '.$deleteLink.']'
);
if ($company['Company']['activity'] <> '') {
   echo $this->Html->tag(
		'dl',
		$this->Html->tag(
		'dt',
		'Сфера деятельности: ').
		$this->Html->tag(
			'dd',
			$company['Company']['activity']
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
	if ($phone_list !== '') {
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
}
if (! empty($emails)) {
	$email_list = '';
	foreach ($emails as $email) {
		if ($email_list !== '') {
			$email_list .= ', ';
		}
		$email_list .= $email['Email']['address'];
	}
	if ($email_list !== '') {
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
}
if ($company['Company']['address'] !== '') {
   echo $this->Html->tag(
		'dl',
		$this->Html->tag(
		'dt',
		'Адрес: ').
		$this->Html->tag(
			'dd',
			$company['Company']['address']
		)
	);
}