<?php
class ClientStatusesController extends AppController {
	
	public $name = 'ClientStatuses';
	
	public function edit() {
		if ($this->RequestHandler->isPost()) {
			$success = true;
			foreach ($this->data['ClientStatus'] as $status) {
				if ($success) {
					$this->ClientStatus->id = $status['id'];
					$success = $this->ClientStatus->save($status);
				}
				else {
					break;
				}
			}
			if ($success) {
				$this->Session->SetFlash('Изменения сохранены');
				$this->redirect(
					array('action' => 'edit')					
				);
			}
			else {
				$this->Session->SetFlash('Не удалось сохранить изменения');
			}
		}
		$this->data =$this->ClientStatus->find('all');
		$this->set(
			'client_statuses',
			$this->data
		);
	}		
}