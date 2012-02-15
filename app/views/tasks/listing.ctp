<?php
echo $this->Html->tag(
	'h2',
	'Задачи'
);
if (empty($tasks)) {
	$createLink = $this->Html->link(
		'Создайте',
		array(
			'action' => 'create'
		)
	);
	echo 'Еще не создано ни одной задачи. '.$createLink.' новую прямо сейчас!';
}
else {
	$createLink = $this->Html->link(
		'Создать новую задачу',
		array(
			'action' => 'create'
		)
	);
	echo $createLink;
	$beforeTasks = array();
	$yesterdayTasks = array();
	$todayTasks = array();
	$tomorrowTasks = array();
	$thisWeekTasks = array();
	$nextWeekTasks = array();
	$thisMonthTasks = array();
	$nextMonthTasks = array();
	$laterTasks = array();
	foreach ($tasks as $task) {
		if ($task['Task']['deadline_date'] <= date('Y-m-d', strtotime("-2days"))) {
			$beforeTasks[] = $task;
		}
		else {
			if ($this->Time->wasYesterday($task['Task']['deadline_date'])) {
				$yesterdayTasks[] = $task;
			}
			else {
				if ($this->Time->isToday($task['Task']['deadline_date'])) {
					$todayTasks[] = $task;
				}
				else {
					if ($this->Time->isTomorrow($task['Task']['deadline_date'])) {
						$tomorrowTasks[] = $task;
					}
					else {
						if ($this->Time->isThisWeek($task['Task']['deadline_date'])) {
							$thisWeekTasks[] = $task;
						}
						else {
							if ($this->Time->isThisWeek(strtotime("{$task['Task']['deadline_date']}-1week"))) {
								$nextWeekTasks[] = $task;
							}
							else {
								if ($this->Time->isThisMonth($task['Task']['deadline_date'])) {
									$thisMonthTasks[] = $task;
								}
								else {
									if ($this->Time->isThisMonth(strtotime("{$task['Task']['deadline_date']}-1month"))) {
										$nextMonthTasks[] = $task;
									}
									else {
										$laterTasks[] = $task;
									}
								}
							}
						}
					}
				}
			}
		}		
	}
	if (! empty($beforeTasks)) {
		echo $this->Html->tag(
			'h4',
			'Раньше'
		);
		$viewTasks->viewGroup($beforeTasks, $companies);
	}
	if (! empty($yesterdayTasks)) {
		echo $this->Html->tag(
			'h4',
			'Вчера'
		);
		$viewTasks->viewGroup($yesterdayTasks, $companies);
	}
	if (! empty($todayTasks)) {
		echo $this->Html->tag(
			'h4',
			'Сегодня'
		);
		$viewTasks->viewGroup($todayTasks, $companies);
	}
	if (! empty($tomorrowTasks)) {
		echo $this->Html->tag(
			'h4',
			'Завтра'
		);
		$viewTasks->viewGroup($tomorrowTasks, $companies);
	}
	if (! empty($thisWeekTasks)) {
		echo $this->Html->tag(
			'h4',
			'Эта неделя'
		);
		$viewTasks->viewGroup($thisWeekTasks, $companies);
	}
	if (! empty($nextWeekTasks)) {
		echo $this->Html->tag(
			'h4',
			'Следующая неделя'
		);
		$viewTasks->viewGroup($nextWeekTasks, $companies);
	}
	if (! empty($thisMonthTasks)) {
		echo $this->Html->tag(
			'h4',
			'Этот месяц'
		);
		$viewTasks->viewGroup($thisMonthTasks, $companies);
	}
	if (! empty($nextMonthTasks)) {
		echo $this->Html->tag(
			'h4',
			'Следующий месяц'
		);
		$viewTasks->viewGroup($nextMonthTasks, $companies);
	}
	if (! empty($laterTasks)) {
		echo $this->Html->tag(
			'h4',
			'Позже'
		);
		$viewTasks->viewGroup($laterTasks, $companies);
	}
}