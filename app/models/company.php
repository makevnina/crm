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
		'Project' => array(
			'foreignKey' => 'artifact_id'
		)
	);
    
    public $validate = array(
        'name' => array(
            'ruleName' => array(
                'rule' => 'notEmpty',
                'requred' => 'true',
                'allowEmpty' => false,
                'message' => 'Введите название компании',
            ),
            'ruleName2' => array(
                'rule' => 'isUnique',
                'message' => 'Такая компания уже существует'
            )
        )
    );
}