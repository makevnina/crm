<?php
class ClientsController extends AppController {

    public $name = 'Clients';

    function index() {
        $this->redirect(
            array(
                'action' => 'listing'
            )
        );
    }

    function listing(){
        $clients = $this->Client->find('all');
        $this->set('clients', $clients);
    }

    function view($id){
        $client = $this->Client->find(
          'first',
           array(
               'conditions' => array ('Client.id' => $id)
           )
        );
        $this->set('client', $client);
    }

    function edit($id){

    }
}