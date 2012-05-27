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
	$clientFilterArray = array();
	if (empty($client_filter[0])) {
		$client_filter[0] = 1;
	}
	foreach ($clients as $client) {
		if (($client_filter[$client['Client']['client_status_id']] == 1)) {
			$clientFilterArray[] = $client;
		}
   }
	if (empty ($clientFilterArray)) {
		echo 'Нет клиентов, удовлетворяющих условиям фильтра.';
	}
	else {
		$clients = $clientFilterArray;
		$aloneClientsArray = array();
		foreach ($clients as $client) {
			if ($client['Client']['company_id'] == 0) {
				$aloneClientsArray[] = $client;
			}
		}
		if (! empty($aloneClientsArray)) {
			$viewClients->viewGroup($aloneClientsArray, $projects);
		}
		$companyClientsArray = array();
		foreach ($companies as $company) {
			foreach ($clients as $client) {
				if ($client['Client']['company_id'] == $company['Company']['id']) {
					$companyClientsArray[$company['Company']['name']][] = $client;
				}
			}
			if (! empty($companyClientsArray[$company['Company']['name']])) {
				$companyName = $this->Html->tag(
					'h3',
					'Компания "'.$this->Html->link(
						$company['Company']['name'],
						array(
							'controller' => 'companies',
							'action' => 'view',
							$company['Company']['id']
						)
					).'"',
					array('style' => 'display: inline')
				);
				if ($company['Company']['state_id'] <> 0) {
					$companyState = $this->Html->tag(
						'span',
						$company['State']['name'].' клиент',
						array(
							'class' => 'state',
							'style' => "background-color: {$company['State']['color']}"
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
				$viewClients->viewGroup($companyClientsArray[$company['Company']['name']], $projects);
			}
		}
	}
}