<?php
class Email extends AppModel {
	
	public $name = 'Email';
	
	public $belongsTo = array(
		'Client' => array(
			'foreignKey' => 'artifact_id'
		),
		'Company' => array(
			'foreignKey' => 'artifact_id'
		)
	);
/*	public $validate = array(
		'address' => array(
			'rule' => array('email', true),
			'message' => 'Введите корректный e-mail адрес',
			'allowEmpty' => true
		)
	);*/
	
	public function save(& $model, $emails) {
		$artifact_type = Inflector::underscore($model->name);
		$email_list = array();
		$email_new_list = array();
		$success = true;
		foreach ($emails as $k => $email) {
			if ($k !== 'new') {
				if ($email !== '') {
					$email_list[] = array(
						'Email' => array(
							'id' => $k,
							'address' => $email
						)
					);
				}
				else {
					$this->delete($k);
				}
			}
		}
		if (! empty($emails['new'])) {
			foreach ($emails['new'] as $email) {
				if ($email !== '') {
					$email_new_list[] = array(
						'artifact_id' => $model->id,
						'artifact_type' => $artifact_type,
						'address' => $email
					);
				}
			}
			foreach ($email_new_list as $email) {
				$success = $this->insert($email);
			}
		}
		foreach ($email_list as $email) {
			$success = parent::save($email);
		}
		return $success;
	}
}
