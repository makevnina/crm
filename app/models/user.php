<?php
class User extends AppModel {

    public $name = 'User';

    public $hasMany = array(
      'Project',
		 'Task'
    );
}