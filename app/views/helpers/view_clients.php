<?php
class ViewClientsHelper extends AppHelper {
	
	public $helpers = array('Html');
	
	public function viewGroup($clients) {
		foreach ($clients as $client) {
			$clientName = $this->Html->tag(
				'h4',
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
			if ($client['Client']['state_id'] <> 0) {
				$clientState = $this->Html->tag(
					'span',
					$client['State']['name'].' клиент',
					array(
						'class' => 'state',
						'style' => "background-color:{$client['State']['color']}"
					)
				);
			}
			else {
				$clientState = '';
			}
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
				$clientName.' '.$clientState.' '.$clientStatus
			);
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
				$projectsArray = array();
				foreach ($projects as $project) {
					if (($project['Project']['artifact_id'] == $client['Client']['id']) 
						AND ($project['Project']['artifact_type'] == 'client')) {
						$projectsArray[] = $project;
						$projectClientType = ' клиента:';
					}
					if (($project['Project']['artifact_id'] == $client['Client']['company_id'])
						AND ($project['Project']['artifact_type'] == 'company')) {
						$projectsArray[] = $project;
						$projectClientType = ' компании клиента:';
					}
				}
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
			if (! empty($projectsArray)) {
				echo $this->Html->tag(
					'h4',
					'Проекты'.$projectClientType,
					array(
							'class' => "details_block block{$client['Client']['id']}"
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
								'class' => "status details_block block{$client['Client']['id']}",
								'style' => "background-color: {$project['ProjectStatus']['color']}"
							)
						);
					}
					else {
						$projectStatus = '';
					}
					echo $this->Html->tag(
						'div',
						$projectNameLink.' '.$projectStatus,
						array(
							'class' => "details_block block{$client['Client']['id']}"
						)
					);
				}
			}
		}
	}
}