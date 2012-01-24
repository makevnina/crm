<?php
echo $this->Html->tag(
        'h2',
        'Список компаний'
);
$createLink = $this->Html->link(
        'Создать компанию',
        array(
            'action' => 'create'
        )
);
echo $this->Html->tag(
        'p',
        $createLink
);
foreach ($companies as $company) {
   $showDetailsLink = $this->Html->link(
		'+',
		'javascript:void(0)',
		array (
			'class' => 'toggle_details',
			'onclick' => "return toggle_details({$company['Company']['id']});"
		)
	);
	$companyLink = $this->Html->tag(
		'h3',
		$this->Html->link(
			$company['Company']['name'],
			array(
				 'action' => 'view',
				 $company['Company']['id']
			)
		)
   );
	echo $companyLink.$showDetailsLink;
	
	if (! empty($company['Company']['activity'])) {
		$activity = $this->Html->tag(
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
	else {
		$activity = '';
	}
	if (! empty($company['Company']['address'])) {
		$address = $this->Html->tag(
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
	else {
		$address = '';
	}
	if (! empty($phones)) {
		$phone_list = '';
		foreach ($phones as $phone) {
			
			if ($phone['Phone']['artifact_id']==$company['Company']['id']) {
				if ($phone_list !== '') {
					$phone_list .= ', ';
				}
				$phone_list .= $phone['Phone']['number'];
			}
		}
		$phone_numbers = $this->Html->tag(
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
	else
		$phone_numbers = '';
	
	if (! empty($emails)) {
		$email_list = '';
		foreach($emails as $email) {
			if ($email['Email']['artifact_id'] == $company['Company']['id']) {
				if ($email_list !== '') {
					$email_list .= ', ';
				}
				$email_list .= $email['Email']['address'];
			}
		}
		if (! empty($email_list)) {
			$email_addresses = $this->Html->tag(
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
		else {
			$email_addresses = '';
		}
	}
	else {
		$email_addresses = '';
	}
	echo $this->Html->tag(
		'div',
		$activity.$address.$phone_numbers.$email_addresses,
		array(
			'class' => "details_block block{$company['Company']['id']}",
			'id' => "block_{$company['Company']['id']}"
		)
	);
	if ($clients <> null) {
		echo $this->Html->tag(
				'h3',
				'Контактные лица компании:',
			array(
				'class' => "details_block block{$company['Company']['id']}"
			)
		);
		foreach ($clients as $client) {
			if ($client['Client']['company_id'] == $company['Company']['id']) {
				$viewClientLink = $this->Html->link(
					$client['Client']['surname'].' '.$client['Client']['name'].' '.$client['Client']['father'],
					array(
						'controller' => 'clients',
						'action' => 'view',
						$client['Client']['id']
					)
				);
				echo $this->Html->tag(
					'p',
					$viewClientLink,
					array(
						'class' => "details_block block{$company['Company']['id']}"
					)
				);
			}
		}
	}
}
