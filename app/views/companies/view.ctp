<?php
$companyName = $this->Html->tag(
	'h2',
	'Компания "'.$company['Company']['name'].'"',
	array('style' => 'display: inline')
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
	'javascript: void(0)',
	array(
		'onclick' => "return deleteCompany({$company['Company']['id']})"
	)
);
$editBar = $this->Html->tag(
	'span',
	'['.$editLink.', '.$deleteLink.']',
	array('class' => 'editBar')
);
echo $this->Html->tag(
	'div',
	$companyName.' '.$editBar
);
if ($company['Company']['state_id'] <> 0) {
	$companyState = $this->Html->tag(
		'span',
		$company['State']['name'].' клиент',
			array(
				'class' => 'state',
				'style' => "background-color:{$company['State']['color']}"
			)
	);
}
else {
	$companyState = '';
}
echo $this->Html->tag(
	'div',
	$companyState,
	array('class' => 'statusBar')
);
if (! empty($company['Company']['activity'])) {
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
	if (! empty($phone_list)) {
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
	if (! empty($email_list)) {
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
if (! empty($company['Company']['address'])) {
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
$viewComments->viewGroup('company', $company['Company']['id'], $comments, $current_user);