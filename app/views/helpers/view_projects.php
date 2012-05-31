<?php
class ViewProjectsHelper extends AppHelper {
	
	public $helpers = array('Html');
	
	public function viewGroup($projects) {
		$tableHeaders = array(
			'Дата начала',
			'Дата планируемого окончания',
			'Дата фактического окончания'
		);
		foreach ($projects as $project) {
			$projectNameLink = $this->Html->tag(
				'h3',
				$this->Html->link(
					$project['Project']['name'],
					array(
						'action' => 'view',
						$project['Project']['id']
					)
				),
				array(
					'style' => 'display: inline'
				)
			);
			if ($project['Project']['project_status_id'] <> 0) {
				$projectStatus = $this->Html->tag(
					'span',
					$project['ProjectStatus']['name'],
					array(
						'class' => 'status',
						'style' => "background: {$project['ProjectStatus']['color']}"
					)
				);
			}
			else {
				$projectStatus = '';
			}
			echo $this->Html->tag(
				'div',
				$projectNameLink.' '.$projectStatus
			);
			if (! empty($project['Project']['budget'])) {
				echo $budget = $this->Html->tag(
					'span',
					$this->Html->tag(
						'b',
						$project['Project']['budget']
					). ' руб.',
					array(
						'class' => 'budget'
					)
				);
			}
			if ($project['Project']['user_id'] <> 0) {
				echo $this->Html->tag(
					'dl',
					$this->Html->tag(
						'dt',
						'Ответственный'
					).$this->Html->tag(
						'dd',				
						$project['User']['surname'].' '.$project['User']['name']
					)
				);
			}
			if ($project['Project']['artifact_id'] <> 0) {
				if ($project['Project']['artifact_type'] == 'client') {
					$clientLink = $this->Html->link(
						$project['Client']['surname'].' '.
							$project['Client']['name'].' '.
							$project['Client']['father'],
						array(
							'controller' => 'clients',
							'action' => 'view',
							$project['Client']['id']
						)
					);
				}
				if ($project['Project']['artifact_type'] == 'company') {
					$clientLink = $this->Html->link(
						'компания "'.$project['Company']['name'].'"',
						array(
							'controller' => 'companies',
							'action' => 'view',
							$project['Company']['id']
						)
					);
				}
				echo $this->Html->tag(
					'dl',
					$this->Html->tag(
						'dt',
						'Клиент'
					).$this->Html->tag(
						'dd',
						$clientLink
					)
				);
			}
			if (! empty($project['Project']['description'])) {
				$descriptionTitle = $this->Html->tag(
					'div',
					$this->Html->tag(
						'b',
						'Описание'
					)
				);

				$description = $this->Html->tag(
					'div',
					$descriptionTitle.$this->Html->tag(
						'div',
						$project['Project']['description']
					),
					array(
						'class' => "description details_block block{$project['Project']['id']}"
					)
				);
			}
			else {
				$description = '';
			}
			if ($project['Project']['start_date'] <> '0000-00-00') {
				$start_date = $project['Project']['start_date'];
			}
			else {
				$start_date = '';
			}
			if ($project['Project']['plan_date'] <> '0000-00-00') {
				$plan_date = $project['Project']['plan_date'];
			}
			else {
				$plan_date = '';
			}
			if ($project['Project']['fact_date'] <> '0000-00-00') {
				$fact_date = $project['Project']['fact_date'];
			}
			else {
				$fact_date = '';
			}
			if ((! empty($start_date)) OR (! empty($plan_date)) OR (! empty($fact_date))) {
				$tableCells = array(
					$start_date,
					$plan_date,
					$fact_date
				);
				$dateTable = $this->Html->tag(
					'table',
					$this->Html->tableHeaders($tableHeaders).
					$this->Html->tableCells($tableCells),
					array(
						'border' => 1,
						'class' => "projects_table details_block block{$project['Project']['id']}"
					)			
				);
			}
			else {
				$tableCells = '';
				$dateTable = '';
			}
			if (! empty($description) OR ! empty($tableCells)) {
				echo $this->Html->link(
					'+',
					'javascript:void(0)',
					array(
						'id' => 'toggle_description',
						'onclick' => "return toggle_details({$project['Project']['id']});"
					)
				);
			}
			echo $this->Html->tag(
				'div',
				$description.$dateTable
			);
		}
	}
}
