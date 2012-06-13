<?php
echo $this->Html->tag(
	'h2',
	'Источники клиентов'
);
$sources = array();
$clientBySource = array();
if (! empty($clients)) {
	foreach ($clients as $client) {
		if ((! in_array($client['Client']['source'], $sources))
				AND (! empty($client['Client']['source']))){
			$sources[] = $client['Client']['source'];
		}
		if (empty($client['Client']['source'])) {
			$clientBySource['Другое'][] = $client;
		}
		else {
			$clientBySource[$client['Client']['source']][] = $client;
		}
	}
	$sources[] = 'Другое';
	if (! empty($sources)) {
		$tableHeaders = array('Источник', 'Количество клиентов');
		$tableCells = array();
		foreach ($sources as $source) {
			$count = count($clientBySource[$source]);
			$padding = $count*10;
			if ($padding > 85) {
				$padding = 85;
			}
			if (empty($source)) {
				$source = 'Другое';
			}
			$tableCells[] = array($source, $this->Html->tag(
				'span',
				$count,
				array(
					'style' => "padding: 5px {$padding}px 5px {$padding}px",
					'class' => 'clientSourcesCount'
				)
			));
		}
		echo $this->Html->tag(
			'table',
			$this->Html->tableHeaders($tableHeaders)
			. $this->Html->tableCells($tableCells),
			array('class' => 'clientSources')
		);
	}
	else {
		echo 'Источников клиентов не найдено.';
	}
}