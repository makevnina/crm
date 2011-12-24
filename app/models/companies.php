<?php
class Company extends AppModel {

    public $name = 'Company';

    public $hasMany = array(
        'Client',
        'Project'
    );
}