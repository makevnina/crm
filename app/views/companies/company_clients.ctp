<?php
$companyNameLink = $this->Html->link(
	$company['Company']['name'],
	array(
		'action' => 'view',
		$company['Company']['id']
	)
);
echo $this->Html->tag(
	'h2',
	'Компания: "'.$companyNameLink.'"'
);
if (empty($clients)) {
	echo 'У данной компании нет контактных лиц.';
}
else {
	$filterClientsArray = array();
	$filterArray = array();
	foreach ($client_filter as $key => $value) {
		if ($value) {
			$filterArray[] = $key;
		}
	}
	foreach ($clients as $client) {
		if (in_array($client['Client']['client_status_id'], $filterArray)) {
			$filterClientsArray[] = $client;
		}
	}
	$clients = $filterClientsArray;
	if (empty($clients)) {
		echo 'Нет контактных лиц, удовлетворяющих условиям фильтра.';
	}
	else {
		echo $this->Html->tag(
			'h3',
			'Контактные лица компании:'
		);
		foreach ($clients as $client) {
			$clientNameLink = $this->Html->tag(
				'h4',
				$this->Html->link(
					$client['Client']['surname'].' '.$client['Client']['name'].' '
					. $client['Client']['father'],
					array(
						'controller' => 'clients',
						'action' => 'view',
						$client['Client']['id']
					)
				),
				array('style' => 'display: inline')
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
				$clientNameLink.' '.$clientStatus
			);
			echo $this->Html->link(
				'+',
				'javascript: void(0)',
				array(
					'onclick' => "return toggle_details({$client['Client']['id']});"
				)
			);
			if ($client['Client']['position'] <> '') {
				echo $this->Html->tag(
					'dl',
					$this->Html->tag(
					'dt',
					'Должность: ').
					$this->Html->tag(
						'dd',
						$client['Client']['position']
					),
					array('class' => "details_block block{$client['Client']['id']}")
				);
			}
			if (! empty($phones)) {
				$phone_list = '';
				foreach ($phones as $phone) {
					if ($phone['Phone']['artifact_id'] == $client['Client']['id']) {
						if ($phone_list !== '') {
							$phone_list .= ', ';
						}
						$phone_list .= $phone['Phone']['number'];
					}
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
						),
						array('class' => "details_block block{$client['Client']['id']}")
					);
				}
			}
			if (! empty($emails)) {
				$email_list = '';
				foreach ($emails as $email) {
					if ($email['Email']['artifact_id'] == $client['Client']['id']) {
						if ($email_list !== '') {
							$email_list .= ', ';
						}
						$email_list .= $email['Email']['address'];
					}
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
						),
						array('class' => "details_block block{$client['Client']['id']}")
					);
				}
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
					),
					array('class' => "details_block block{$client['Client']['id']}")
				);
			}
		}
	}
}
