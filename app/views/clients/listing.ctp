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
		$client_filter[0] = 0;
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
			$viewClients->viewGroup($aloneClientsArray);
		}
		$companyClientsArray = array();
		foreach ($companies as $company) {
			foreach ($clients as $client) {
				if ($client['Client']['company_id'] == $company['Company']['id']) {
					$companyClientsArray[$company['Company']['name']][] = $client;
				}
			}
			if (! empty($companyClientsArray[$company['Company']['name']])) {
				echo $this->Html->tag(
					'h3',
					'Компания "'.$this->Html->link(
						$company['Company']['name'],
						array(
							'controller' => 'companies',
							'action' => 'view',
							$company['Company']['id']
						)
					).'"'
				);
				$viewClients->viewGroup($companyClientsArray[$company['Company']['name']]);
			}
		}
	}
}