<?php
class ViewCommentsHelper extends AppHelper {
	
	public $helpers = array('Html', 'Form');
	
	public function viewGroup($artifact_type, $artifact_id, $comments, $current_user) {
		$controller = Inflector::pluralize($artifact_type);
		if (! empty($comments)) {
			echo $this->Html->tag(
				'h3',
				'Комментарии:',
				array('class' => 'comment_title')
			);
			foreach ($comments as $comment) {
				$user = $this->Html->tag(
					'span',
					$comment['User']['surname'].' '.$comment['User']['name'].':',
					array('class' => 'comment_user')
				);
				$comment_time = $this->Html->tag(
					'span',
					$comment['Comment']['comment_time'],
					array('class' => 'comment_time')
				);
				$text = $this->Html->tag(
					'div',
					$comment['Comment']['text'],
					array('class' => 'comment_text')
				);
				if (($current_user['User']['id'] == $comment['User']['id'])
						OR ($current_user['User']['type'] == 'администратор')){
					$deleteLink = $this->Html->link(
						'удалить',
						array(
							'controller' => $controller,
							'action' => 'deleteComment',
							$comment['Comment']['id'],
							$artifact_id
						),
						array('class' => 'deleteComment')
					);
				}
				else {
					$deleteLink = '';
				}
				echo $this->Html->tag(
					'div',
					$user.$text.$comment_time.$deleteLink,
					array(
						'class' => 'comment',
						'id' => $comment['Comment']['id']
					)
				);
			}
		}
		echo $this->Form->create(
			'Comment',
			array('url' => array(
				'controller' => $controller,
				'action' => 'view',
				$artifact_id
			))
		);
		echo $this->Html->tag(
			'div',
			$this->Form->input(
				'text',
				array(
					'label' => 'Новый комментарий',
					'type' => 'textarea'
				)
			),
			array('class' => 'new_comment')
		);
		echo $this->Form->end('Добавить');
	}
}
