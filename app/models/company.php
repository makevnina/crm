<?php
class Company extends AppModel {

	public $name = 'Company';

	public $hasMany = array(
		'Client' => array(
			'dependent' => false
		),
		'Phone' => array(
			'foreignKey' => 'artifact_id'
		),
		'Email' => array(
			'foreignKey' => 'artifact_id'
		),
		'Project' => array(
			'foreignKey' => 'artifact_id',
			'conditions' => array (
				array ('Project.artifact_type' => 'company')
			),
		),
		'Comment' => array(
			'foreignKey' => 'artifact_id',
			'dependent' => true
		)
	);
	
	public $belongsTo = array(
		'State'
	);
    
    public $validate = array(
        'name' => array(
            'ruleName' => array(
                'rule' => 'notEmpty',
                'message' => 'Введите название компании',
            ),
            'ruleName2' => array(
                'rule' => 'isUnique',
                'message' => 'Такая компания уже существует'
            )
        )
    );
}