<?php
class Phone extends AppModel {
	
	public $name = 'Phone';
	
	public $belongsTo = array(
		'Client' => array(
			'foreignKey' => 'artifact_id'
		),
		'Company' => array(
			'foreignKey' => 'artifact_id'
		)
	);
	
	public function save(& $model, $phones) {
		$artifact_type = Inflector::underscore($model->name);
		$phone_list = array();
		$phone_new_list = array();
		foreach ($phones as $k => $phone) {
			if ($k !== 'new') {	
				$phone_list[] = array(
					'Phone' =>	array(
						'id' => $k,
						'number' => $phone
					)
				);
			}
		}
		if (! empty ($phones['new'])) {
			foreach ($phones['new'] as $phone) {
				$phone_new_list[] = array(
					'artifact_id' => $model->id,
					'artifact_type' => $artifact_type,
					'number' => $phone
				);
			}
			foreach ($phone_new_list as $phone) {
				$success = $this->insert($phone);
			}
		}
		foreach ($phone_list as $phone_list){
			$success = parent::save($phone_list);
		}
		return $success;		
	}
}
