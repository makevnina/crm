<?php
if (empty($tasks)) {
	$createLink = $this->Html->link(
		'создайте',
		array(
			'action' => 'create'
		)
	);
	echo 'Еще не создано ни одной задачи, '.$createLink.' новую прямо сейчас!';
}
else {
		$filterTasksArray = array();
		$filterArray = array();
		foreach ($task_filter as $key => $value) {
			if ($value) {
				$filterArray[] = $key;
			}
		}
		foreach ($tasks as $task) {
			if ((in_array($task['Task']['task_status_id'], $filterArray))
				AND (in_array($task['Task']['type'], $filterArray))) {
				$filterTasksArray[] = $task;
			}
		}
		$tasks = $filterTasksArray;
		$finishedTasks = array();
		$overdueTasks = array();
		$beforeTasks = array();
		$yesterdayTasks = array();
		$todayTasks = array();
		$tomorrowTasks = array();
		$thisWeekTasks = array();
		$nextWeekTasks = array();
		$thisMonthTasks = array();
		$nextMonthTasks = array();
		$laterTasks = array();
		
		if ($isAdmin) {
			$TasksArray = array();
			if (! empty($task_filter['Task']['user_id'])) {
				if ($task_filter['Task']['user_id'] <> 0) {
					foreach ($tasks as $task) {
						if ($task['Task']['user_id'] == $task_filter['Task']['user_id']) {
							$TasksArray[] = $task;
						}
					}
					$tasks = $TasksArray;
				}
			}
		}
		if (! empty($task_filter['Task']['client_id'])) {
			$TasksArray = array();
			if ($task_filter['Task']['client_id'] <> 0) {
				foreach ($tasks as $task) {
					if ($task['Task']['client_id'] == $task_filter['Task']['client_id']) {
						$TasksArray[] = $task;
					}
				}
			}
			$tasks = $TasksArray;
		}
		if (! empty($task_filter['Task']['project_id'])) {
			$TasksArray = array();
			if ($task_filter['Task']['project_id'] <> 0) {
				foreach ($tasks as $task) {
					if ($task['Task']['project_id'] == $task_filter['Task']['client_id']) {
						$TasksArray[] = $task;
					}
				}
			}
			$tasks = $TasksArray;
		}
		if (! empty($tasks)) {
		foreach ($tasks as $task) {
			if ( $task['TaskStatus']['name'] == 'выполнена' ) {
				$finishedTasks[] = $task;
			}
			else {
				if ($task['Task']['deadline'] < date('Y-m-d H:i:s')) {
					$overdueTasks[] = $task;
				}
				else {
					if ($this->Time->isToday($task['Task']['deadline'])) {
						$todayTasks[] = $task;
					}
					else {
						if ($this->Time->isTomorrow($task['Task']['deadline'])) {
							$tomorrowTasks[] = $task;
						}
						else {
							if ($this->Time->isThisWeek($task['Task']['deadline'])) {
								$thisWeekTasks[] = $task;
							}
							else {
								if ($this->Time->isThisWeek(strtotime("{$task['Task']['deadline']}-1week"))) {
									$nextWeekTasks[] = $task;
								}
								else {
									if ($this->Time->isThisMonth($task['Task']['deadline'])) {
										$thisMonthTasks[] = $task;
									}
									else {
										if ($this->Time->isThisMonth(strtotime("{$task['Task']['deadline']}-1month"))) {
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
		if ($task_filter['finished'] == 1) {
			if (! empty($finishedTasks)) {
				echo $this->Html->tag(
					'h3',
					'Завершенные задачи'
				);
				$viewTasks->viewGroup($finishedTasks, $companies);
			}
		}
		if ($task_filter['overdue'] == 1) {
			if (! empty($overdueTasks)) {
				echo $this->Html->tag(
					'h3',
					'Просроченные задачи',
					array('class' => 'overdueTasksTitle')
				);
				$viewTasks->viewGroup($overdueTasks, $companies);
			}
		}
		if ($task_filter['today'] == 1) {
			if (! empty($todayTasks)) {
				echo $this->Html->tag(
					'h3',
					'Сегодня'
				);
				$viewTasks->viewGroup($todayTasks, $companies);
			}
		}
		if ($task_filter['tomorrow'] == 1) {
			if (! empty($tomorrowTasks)) {
				echo $this->Html->tag(
					'h3',
					'Завтра'
				);
				$viewTasks->viewGroup($tomorrowTasks, $companies);
			}
		}
		if ($task_filter['this_week'] == 1) {
			if (! empty($thisWeekTasks)) {
				echo $this->Html->tag(
					'h3',
					'Эта неделя'
				);
				$viewTasks->viewGroup($thisWeekTasks, $companies);
			}
		}
		if ($task_filter['next_week'] == 1) {
			if (! empty($nextWeekTasks)) {
				echo $this->Html->tag(
					'h3',
					'Следующая неделя'
				);
				$viewTasks->viewGroup($nextWeekTasks, $companies);
			}
		}
		if ($task_filter['this_month'] == 1) {
			if (! empty($thisMonthTasks)) {
				echo $this->Html->tag(
					'h3',
					'Этот месяц'
				);
				$viewTasks->viewGroup($thisMonthTasks, $companies);
			}
		}
		if ($task_filter['next_month'] == 1) {
			if (! empty($nextMonthTasks)) {
				echo $this->Html->tag(
					'h3',
					'Следующий месяц'
				);
				$viewTasks->viewGroup($nextMonthTasks, $companies);
			}
		}
		if ($task_filter['later'] == 1) {
			if (! empty($laterTasks)) {
				echo $this->Html->tag(
					'h3',
					'Позже'
				);
				$viewTasks->viewGroup($laterTasks, $companies);
			}
		}
	}
}