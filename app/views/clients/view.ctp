<?php
 echo $this->Html->tag(
    'b',
    $client['Client']['surname'].' '.$client['Client']['name'].' '.$client['Client']['father']
 );
 if ($client['Client']['position'] <> '') {
    echo $this->Html->tag(
        'p',
        '&nbsp'
     );
    echo 'Должность: '.$client['Client']['position'];
}
if ($client['Client']['address'] <> '') {
    echo $this->Html->tag(
        'p',
        '&nbsp'
    );
    echo 'Адрес: '.$client['Client']['address'];
}