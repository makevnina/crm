<?php
echo $this->Html->tag(
        'h2',
        'Список компаний'
);
$createLink = $this->Html->link(
        'Создать компанию',
        array(
            'action' => 'create'
        )
);
echo $this->Html->tag(
        'p',
        $createLink
);
foreach ($companies as $company) {
   echo $this->Html->link(
      $company['Company']['name'],
      array(
          'action' => 'view',
          $company['Company']['id']
      )
   );
   echo $this->Html->tag(
           'p',
           'Сфера деятельности: '.$company['Company']['activity']
   );
   echo $this->Html->tag(
           'p',
           'Адрес: '.$company['Company']['address']
   );
}
