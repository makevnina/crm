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
   $showDetailsLink = $this->Html->link(
		'+',
		'javascript:void(0)',
		array ('class' => 'toggle_details')
	);
	$companyLink = $this->Html->tag(
		'h3',
		$this->Html->link(
			$company['Company']['name'],
			array(
				 'action' => 'view',
				 $company['Company']['id']
			)
		)
   );
	echo $companyLink.$showDetailsLink;
	$activity_input = $this->Html->tag(
		'dl',
		$this->Html->tag(
		'dt',
		'Сфера деятельности: ').
		$this->Html->tag(
			'dd',
			$company['Company']['activity']
		)
	);
   $address_input = $this->Html->tag(
		'dl',
		$this->Html->tag(
		'dt',
		'Адрес: ').
		$this->Html->tag(
			'dd',
			$company['Company']['address']
		)
	);
	echo $this->Html->tag(
		'div',
		$activity_input.$address_input,
		array(
			'class' => "details_block",
			'id' => "block_{$company['Company']['id']}"
		)
	);
}
