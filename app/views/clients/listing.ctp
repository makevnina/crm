<?php
echo $this->Html->tag(
    'h2',
    'Список клиентов'
);
if (empty($clients)) {
    $createLink = $this->Html->link(
        'создайте',
        array(
            'action' => 'create'
        )    
    );
    echo $this->Html->tag(
        'p',
        'Нет ни одного клиента, '.$createLink.' нового прямо сейчас!'
    );
}
else {
	$viewAllClients = true;
	if (! empty($client_filter)) {
		foreach ($client_filter as $k => $filter) {
			if ($filter <> 1) {
				$viewAllClients = false;
				break;
			}
		}
	}
   foreach ($clients as $client) {
		if (empty($client_filter[$client['Client']['client_status_id']])) {
			$client_filter[$client['Client']['client_status_id']] = 0;
		}
		if (($viewAllClients)
			OR ($client_filter[$client['Client']['client_status_id']] == 1)) {
		$clientName = $this->Html->tag(
			'h3',
			$this->Html->link(
				$client['Client']['surname'].' '.$client['Client']['name'].' '.$client['Client']['father'],
				array(
					'action' => 'view',
					$client['Client']['id']
				)
			),
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
					'style' => "background-color:{$client['ClientStatus']['color']}"
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
		if ($client['Company']['id'] <> 0) {
			echo $this->Html->tag(
				'h4',
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
		if ($client['Client']['position'] <> ''){
			$position = $this->Html->tag(
				'dl',
				$this->Html->tag(
					'dt',
					'Должность: '
				).
				$this->Html->tag(
					'dd',
					$client['Client']['position']
				)
			);
		}
		else {
			$position = '';
		}
		if ($client['Client']['address'] <> '') {
			$address = $this->Html->tag(
				'dl',
				$this->Html->tag(
					'dt',
					'Адрес: '
				).
				$this->Html->tag(
					'dd',
					$client['Client']['address']
				)
			);
		}
		else {
			$address = '';
		}		
		if (! empty($phones)) {
			$phone_list = '';
			foreach ($phones as $phone) {
				if ($phone['Phone']['artifact_id'] == $client['Client']['id']) {
					if ($phone_list !== ''){
						$phone_list .= ', ';
					}
					$phone_list .= $phone['Phone']['number'];
				}				
			}
			if (! empty($phone_list)) {
				$phone_numbers = $this->Html->tag(
					'dl',
					$this->Html->tag(
						'dt',
						'Телефон: '
					).
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
		else {
			$phone_numbers = '';
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
				$email_addresses = $this->Html->tag(
					'dl',
					$this->Html->tag(
						'dt',
						'E-mail:'
					).
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
		$projectClientType = '';
		if (! empty($projects)) {
			$projectArrayLink = array();
			foreach ($projects as $project) {
				if (($project['Project']['artifact_id'] == $client['Client']['id']) 
					AND ($project['Project']['artifact_type'] == 'client')) {
					$projectArrayLink[] = $this->Html->link(
						$project['Project']['name'],
						array(
							'controller' => 'projects',
							'action' => 'view',
							$project['Project']['id']
						)
					);
					$projectClientType = ' клиента:';
				}
				if (($project['Project']['artifact_id'] == $client['Client']['company_id'])
					AND ($project['Project']['artifact_type'] == 'company')) {
					$projectArrayLink[] = $this->Html->link(
						$project['Project']['name'],
						array(
							'controller' => 'projects',
							'action' => 'view',
							$project['Project']['id']
						)
					);
					$projectClientType = ' компании клиента:';
				}
			}
		}
		else {
			$projectArrayLink = '';
		}
		$DetailsLink = $this->Html->link(
			'+',
			'javascript:void(0)',
			array (
				'class' => 'toggle_details',
				'onclick' => "return toggle_details({$client['Client']['id']});"
			)
		);
		echo $this->Html->tag(
			'div',
			$DetailsLink
		);
		echo $this->Html->tag(
			'div',
			$position.$address.$phone_numbers.$email_addresses,
			array(
				'class' => "details_block block{$client['Client']['id']}",
				'id' => "block_{$client['Client']['id']}"
			)
		);
		if (! empty($projectArrayLink)) {
			echo $this->Html->tag(
				'h4',
				'Проекты'.$projectClientType,
				array(
						'class' => "details_block block{$client['Client']['id']}"
				)
			);
			foreach ($projectArrayLink as $projectLink) {
				echo $this->Html->tag(
					'div',
					$projectLink,
					array(
						'class' => "details_block block{$client['Client']['id']}"
					)
				);
			}
		}
			}
   }
}