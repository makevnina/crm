<?php
class Client extends AppModel {

    public $name = 'Client';

    public $belongsTo = 'Company';

    public $hasMany = 'Project';

}