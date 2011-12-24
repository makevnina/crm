<?php
$id = 0;
foreach ($clients as $client) {
    echo $this->Html->tag('p');
    echo $this->Html->tag(
        'b',
        $this->Html->tag(
            'a',
            $client['Client']['surname'].' '.$client['Client']['name'].' '.$client['Client']['father'],
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
    if ($client['Client']['position'] <> ''){
        echo $this->Html->tag('p');
        echo '&emsp;'.$client['Client']['position'];
    }
    if ($client['Client']['address'] <> '') {
        echo $this->Html->tag('p');
        echo '&emsp;'.$client['Client']['address'];
    }
}