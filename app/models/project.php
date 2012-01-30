<?php
class Project extends AppModel {

    public $name = 'Project';
	 
	 public $validate = array(
        'name' => array(
            'ruleName' => array(
                'rule' => 'notEmpty',
                'requred' => 'true',
                'allowEmpty' => false,
                'message' => 'Введите название проекта',
            ),
            'ruleName2' => array(
                'rule' => 'isUnique',
                'message' => 'Такой проект уже существует'
            )
        )
    );

    public $belongsTo = array(
        'Client' => array(
            'classname' => 'Client',
            'foreignKey' => 'artifact_id',
            'unique' => 'false'
        ),
        'Company' => array(
            'classname' => 'Company',
            'foreignKey' => 'artifact_id',
            'unique' => 'false'
        ),
        'User'
    );
}