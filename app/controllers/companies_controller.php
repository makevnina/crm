<?php
class CompaniesController extends AppController {
   
   public $name = 'Companies';
   
   public $uses = array(
       'Company',
       'Client'
   );
   
   function index() {
      $this->redirect(
              array(
                  'action' => 'listing'
              )
      );
   }
   
   function listing() {
      $this->set(
              'companies',
              $this->Company->find('all')
      );
   }
   
   function create() {
      if ($this->RequestHandler->isPost()) {
         $success = $this->Company->save($this->data);
         if ($success) {
            $this->Session->SetFlash('Компания создана');
         }
         else {
            $this->Session->SetFlash('Компанию не удалось создать');
         }
         $this->redirect(
                 array(
                     'action' => 'listing'
                 )
         );
      }
   }
   
   function view($id) {
      $this->set(
              'company',
              $this->Company->find(
                      'first',
                      array(
                          'conditions' => array(
                              'Company.id' => $id
                          )
                      )
              )
      );
      $this->set(
              'clients',
              $this->Client->find(
                      'all',
                      array(
                          'conditions' => array(
                              'Client.company_id' => $id
                          )
                      )
              )
      );
   }
   
   function edit($id) {
      $this->Company->id = $id;
      if ($this->RequestHandler->isPost()) {
         $success = $this->Company->save($this->data);
         if ($success) {
            $this->Session->SetFlash('Изменения сохранены');
         }
         else {
            $this->Session->SetFlash('Не удалось сохранить изменения');
         }
         $this->redirect(
                 array(
                     'action' => 'listing'
                 )
         );
      }
      else {
         $this->data = $this->Company->find(
                 'first',
                 array(
                     'conditions' => array(
                         'Company.id' => $id
                     )
                 )
         );
         $this->set(
                 'company',
                 $this->data
         );
      
         $this->render('create');
      }
      
   }
   
   function delete($id) {
      $this->Company->delete($id, $cascade = true);
      $this->Session->SetFlash('Компания успешно удалена');
      $this->redirect(
              array(
                  'action' => 'listing'
              )
      );
   }
   
}
