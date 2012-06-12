<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $this->Html->charset(); ?>
		<title>
			<?php echo $title_for_layout; ?>
		</title>
		<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('common');
		echo $this->Html->css('jquery-ui');
		echo $this->Html->css('nav-menu');
		echo $this->Html->css('sidebar');
		echo $this->Html->css('jPicker-1.1.6');
		echo $this->Html->css('jPicker');
		echo $this->Html->css('jquery.editable-select');
		echo $this->Html->script('jquery-1.7.1.min.js');
		echo $this->Html->script('jpicker-1.1.6.min.js');
		echo $this->Html->script('scripts.js');
		echo $this->Html->script('jquery-ui-1.8.17.custom.min.js');
		echo $this->Html->script('jquery-ui-timepicker-addon.js');
		echo $this->Html->script('jquery.editable-select.pack.js');

		echo $scripts_for_layout;
		?>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h1 id="logo"><?= $this->Html->link('CRM', '/') ?></h1>
				<span class ="login">
					<?php
					if (! empty($current_user)) {
						if (! empty($current_user['User']['name'])) {
							$name = $current_user['User']['surname'].' '.$current_user['User']['name'];
						}
						else {
							$name = $current_user['User']['login'];
						}
						$logoutLink = $this->Html->link(
							'Выйти',
							array('controller' => 'users', 'action' => 'logout')
						);
						echo $name.',&nbsp;'.$logoutLink;
					}
					?>
			</span>
			</div>
			<?php if (! empty($current_user)): ?>
				<div id="navigation_menu"><?= $navigationMenu->render() ?></div>
			<?php endif; ?>
			<table id="content-wrapper" cellpadding="0" cellspacing="0">
				<tr>
					<? if(! empty($sidebar_element)): ?>
						<td class="sidebar">
							<div id="sidebar"><?= $this->element('sidebar' . DS . $sidebar_element) ?></div>
						</td>
					<? endif; ?>
					<td class="content">
						<div id="content">
							<?php echo $this->Session->flash(); ?>
							<?php echo $content_for_layout; ?>
						</div>
					</td>
				</tr>
			</table>
			<div id="footer">
				<span>Автор: <a href="mailto:polly.makevnina@gmail.com">Макевнина Полина</a></span>
			</div>
		</div>
		<?php echo $this->element('sql_dump'); ?>
	</body>
</html>