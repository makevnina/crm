<? $url = 'http://' . Configure::read('Email.host'); ?>

<p>Привет, <?= $user['name'] ?> <?= $user['surname'] ?></p>
<p>Напоминаем:</p>

<? if(! empty($user['expired_soon'])): ?>
	<p>Задачи, дедлайн которых уже скоро</p>
	<ul>
	<? foreach($user['expired_soon'] as $task): ?>
		<li>
			<a href="<?= $url . "/tasks/view/{$task['id']}" ?>">
				<?= $task['name'] ?>
			</a>
			(<?= $task['deadline'] ?>)
		</li>
	<? endforeach; ?>
	</ul>
<? endif; ?>
<? if(! empty($user['already_expired'])): ?>
	<p>Просроченные задачи</p>
	<ul>
	<? foreach($user['already_expired'] as $task): ?>
		<li>
			<a href="<?= $url . "/tasks/view/{$task['id']}" ?>">
				<?= $task['name'] ?>
			</a>
			(<?= $task['deadline'] ?>)
		</li>
	<? endforeach; ?>
	</ul>
<? endif; ?>
