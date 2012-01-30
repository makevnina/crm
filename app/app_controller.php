<?php

class AppController extends Controller {

	public $components = array(
		'Session',
		'RequestHandler'
	);
	public $helpers = array(
		'Html',
		'Session',
		'Form',
		'NavigationMenu',
	);

}