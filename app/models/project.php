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
            'jointables' => 'projects_clients',
            'foreignKey' => 'artifact_id',
            'associationForeignKey' => 'artifact_id',
            'unique' => 'false'
        ),
        'Company' => array(
            'classname' => 'Client',
            'jointables' => 'projects_clients',
            'foreignKey' => 'artifact_id',
            'associationForeignKey' => 'artifact_id',
            'unique' => 'false'
        ),
        'User'
    );
}