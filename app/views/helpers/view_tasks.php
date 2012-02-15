<?php
class ViewTasksHelper extends AppHelper {
	
	public $helpers = array('Html');
	
	public function viewGroup($tasks, $companies) {
		foreach ($tasks as $task) {
			echo $this->Html->tag(
				'h3',
				$this->Html->link(
					$task['Task']['name'],
					array(
						'action' => 'view',
						$task['Task']['id']
					)
				)
			);
			echo $this->Html->tag(
					'span',
					$task['TaskState']['name'],
					array(
						'class' => 'status',
						'style' => "background: {$task['TaskState']['color']}"
					)
				).' '.
				$this->Html->tag(
					'span',
					$task['Task']['deadline_date'].' '.$task['Task']['deadline_time']
			);	
			$showDetailsLink = $this->Html->link(
				'+',
				'javascript:void(0)',
				array(
					'id' => 'toggle_description',
					'onclick' => "return toggle_details({$task['Task']['id']})"
				)
			);
			echo $this->Html->tag(
				'div',
				$showDetailsLink
			);		
			$user = $this->Html->tag(
				'dl',
				$this->Html->tag(
					'dt',
					'Ответственный'
				).$this->Html->tag(
					'dd',
					'<ФИО менеджера>'
				)
			);
			if (! empty($task['Client']['name'])) {
				$clientLink = $this->Html->link(
					$task['Client']['surname'].' '.$task['Client']['name'].' '.
						$task['Client']['father'],
					array(
						'controller' => 'clients',
						'action' => 'view',
						$task['Client']['id']
					)
				);
				$companyLink = '';
				if ($task['Client']['company_id'] !== 0) {
					foreach ($companies as $company) {
						if ($company['Company']['id'] == $task['Client']['company_id']) {
							$companyLink = ' ('.$this->Html->link(
								'компания "'.$company['Company']['name'].'"',
								array(
									'controller' => 'companies',
									'action' => 'view',
									$company['Company']['id']
								)
							).')';
							break;
						}
					}
				}
				$client = $this->Html->tag(
					'dl',
					$this->Html->tag(
						'dt',
						'Клиент'
					).$this->Html->tag(
						'dd',
						$clientLink.$companyLink
					)
				);
			}
			else {
				$client = '';
			}
			if (!empty($task['Project']['name'])){
				$projectLink = $this->Html->link(
					$task['Project']['name'],
					array(
						'controller' => 'projects',
						'action' => 'view',
						$task['Project']['id']
					)
				);
				$project = $this->Html->tag(
					'dl',
					$this->Html->tag(
						'dt',
						'Проект'
					).$this->Html->tag(
						'dd',
						$projectLink
					)
				);
			}
			else {
				$project = '';
			}
			if (! empty($task['Task']['description'])) {
				$description = $this->Html->tag(
					'div',
					$this->Html->tag(
						'div',
						$this->Html->tag(
							'b',
							'Описание'
						)
					).$this->Html->tag(
						'div',
						$task['Task']['description']
					),
					array(
						'style' => 'border: 1px solid #ccc; width: 32%'
					)
				);
			}
			else {
				$description = '';
			}
			echo $this->Html->tag(
				'div',
				$user.$client.$project.$description,
				array(
					'class' => "details_block block{$task['Task']['id']}"
				)
			);
		}
	}
}
