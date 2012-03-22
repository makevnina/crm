<?php
echo $this->Html->tag(
        'h2',
        'Список компаний'
);
if (empty($companies)) {
	$createLink = $this->Html->link(
		'создайте',
		array('action' => 'create')
	);
	echo $this->Html->tag(
		'p',
		'Нет ни одной компании, '.$createLink.' новую прямо сейчас!'
	);
}
else {
	foreach ($companies as $company) {
		$companyName = $this->Html->tag(
			'h3',
			$this->Html->link(
				$company['Company']['name'],
				array(
					 'action' => 'view',
					 $company['Company']['id']
				)
			),
			array(
				'style' => 'display: inline'
			)
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
			$companyName.' '.$companyState
		);

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
			if (!empty ($phone_list)) {
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
			else {
				$phone_numbers = '';
			}
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
		if (! empty($activity) OR !empty($address) OR !empty($phone_numbers) OR !empty($email_addresses)) {		
			$detailsDiv = $this->Html->tag(
				'div',
				$activity.$address.$phone_numbers.$email_addresses,
				array(
					'class' => "details_block block{$company['Company']['id']}",
					'id' => "block_{$company['Company']['id']}"
				)
			);
		}
		else {
			$detailsDiv = '';
		}
		if (! empty($clients)) {
			$clientsArray = array();
			foreach ($clients as $client) {
				if ($client['Client']['company_id'] == $company['Company']['id']) {
					$clientsArray[] = $client;
				}
			}
		}
		if (! empty($projects)) {
			$projectsArray = array();
			foreach ($projects as $project) {
				if ($project['Project']['artifact_id'] == $company['Company']['id']) {
					$projectsArray[] = $project;
				}
			}
		}
		$showDetailsLink = $this->Html->link(
			'+',
			'javascript:void(0)',
			array (
				'class' => 'toggle_details',
				'onclick' => "return toggle_details({$company['Company']['id']});"
			)
		);
		if ((! empty($detailsDiv)) OR (!empty($viewClientLinks)) OR (! empty($projectsArray))) {
			echo $showDetailsLink;
		}
		if (!empty ($detailsDiv)) {
			echo $detailsDiv;
		}
		if (! empty($clientsArray)) {
			echo $this->Html->tag(
				'h4',
				'Контактные лица компании:',
				array(
					'class' => "details_block block{$company['Company']['id']}"
				)
			);
			foreach ($clientsArray as $client) {
				$clientName = $this->Html->link(
					$client['Client']['surname'].' '.$client['Client']['name']
					. ' '.$client['Client']['father'],
					array(
						'controller' => 'clients',
						'action' => 'view',
						$client['Client']['id']
					)
				);
				if ($client['Client']['client_status_id'] <> 0) {
					$clientStatus = $this->Html->tag(
						'span',
						$client['ClientStatus']['name'],
						array(
							'style' => "background-color: {$client['ClientStatus']['color']}",
							'class' => 'status'
						)
					);
				}
				else {
					$clientStatus = '';
				}
				echo $this->Html->tag(
					'div',
					$clientName.' '.$clientStatus,
					array(
						'class' => "details_block block{$company['Company']['id']}"
					)
				);
			}
		}
		if (! empty($projectsArray)) {
			echo $this->Html->tag(
				'h4',
				'Проекты компании:',
				array(
					'class' => "details_block block{$company['Company']['id']}"
				)
			);
			foreach ($projectsArray as $project) {
				$projectNameLink = $this->Html->link(
					$project['Project']['name'],
					array(
						'controller' => 'projects',
						'action' => 'view',
						$project['Project']['id']
					)
				);
				if ($project['Project']['project_status_id'] <> 0) {
					$projectStatus = $this->Html->tag(
						'span',
						$project['ProjectStatus']['name'],
						array(
							'class' => 'status',
							'style' => "background-color: {$project['ProjectStatus']['color']}"
						)
					);
				}
				echo $this->Html->tag(
					'div',
					$projectNameLink.' '.$projectStatus,
					array(
						'class' => "details_block block{$company['Company']['id']}"
					)
				);
			}
		}
	}
}
