<?php
	
	echo $this->Form->create('User', array ('controller' => 'users', 'action' => 'login'));
	
	echo $this->Form->input('login', array ('label' => 'Логин'));
	
	echo $this->Form->input('password', array ('label' => 'Пароль', 'type' => 'password'));
	
	echo $this->Form->end('Войти');