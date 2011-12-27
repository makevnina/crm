<?php
echo $this->Html->link(
        'К списку компаний',
        array(
            'action' => 'listing'
        )
);
echo $this->Html->tag(
         'h2',
         $company['Company']['name']
);
$editLink = $this->Html->link(
        'редактировать',
        array(
            'action' => 'edit',
            $company['Company']['id']
        )
);
$deleteLink = $this->Html->link(
        'удалить',
        array(
            'action' => 'delete',
            $company['Company']['id']
        )
);
echo $this->Html->tag(
        'p',
        '['.$editLink.', '.$deleteLink.']'
);
if ($company['Company']['activity'] <> '') {
   echo $this->Html->tag(
           'p',
           'Сфера деятельности: '.$company['Company']['activity']
   );
}
if ($company['Company']['address'] <> '') {
   echo $this->Html->tag(
           'p',
           'Адрес: '.$company['Company']['address']
   );
}
if ($clients <> null) {
   echo $this->Html->tag(
         'h3',
         'Контактные лица компании:'  
   );
   foreach ($clients as $client) {
      echo $this->Html->tag(
              'p',
              $client['Client']['surname'].' '.$client['Client']['name'].' '.$client['Client']['father']
      );
   }
}