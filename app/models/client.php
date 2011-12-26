<?php
class Client extends AppModel {

    public $name = 'Client';

    public $belongsTo = 'Company';

   // public $hasMany = 'Project';
    public $validate = array(
      'surname' => array(
          'rule' => 'notEmpty',
          'requred' => 'true',
          'allowEmpty' => false,
          'message' => 'Фамилия клиента обязательна для заполнения'
      ),
      'name' => array(
          'rule' => 'notEmpty',
          'requred' => 'true',
          'allowEmpty' => false,
          'message' => 'Имя клиента обязательно для заполнения'
      ),
    );
}