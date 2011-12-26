<?php
$id = 0;
echo $this->Html->tag(
    'h2',
    'Список клиентов'
);

if (empty($clients)) {
    $createLink = $this->Html->link(
        'создайте',
        array(
            'action' => 'create'
        )    
    );
    echo $this->Html->tag(
        'p',
        'Нет ни одного клиента, '.$createLink.' нового прямо сейчас!'
    );
}
else {
   $createLink = $this->Html->link(
           'Создать нового клиента',
           array(
               'action' => 'create'
           )
   );
   echo $createLink;
   foreach ($clients as $client) {
       echo $this->Html->tag('p');
       echo $this->Html->tag(
           'b',
           $this->Html->tag(
               'a',
               $this->Html->tag(
                       'h3',
                       $client['Client']['surname'].' '.$client['Client']['name'].' '.$client['Client']['father']
               ),
               array(
                   'href' => $this->Html->url(
                       array(
                           'controller' => 'clients',
                           'action' => 'view',
                           $id => $client['Client']['id']
                       )
                   )
               )
           )
       );
       if ($client['Company']['id'] <> 0) {
          echo $this->Html->link(
                  'Компания '.$client['Company']['name'],
                  array(
                      'controller' => 'companies',
                      'action' => 'view',
                      $client['Company']['id']
                  )
          );
       }
       if ($client['Client']['position'] <> ''){
           echo $this->Html->tag(
                   'p',
                   $client['Client']['position']
           );
       }
       if ($client['Client']['address'] <> '') {
           echo $this->Html->tag(
                   'p',
                   $client['Client']['address']
           );
       }
   }
}