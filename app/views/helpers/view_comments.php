<?php
class ViewCommentsHelper extends AppHelper {
	
	public $helpers = array('Html', 'Form');
	
	public function viewGroup($artifact_type, $artifact_id, $comments) {
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
				echo $this->Html->tag(
					'div',
					$user.$text.$comment_time,
					array('class' => 'comment')
				);
			}
		}
		echo $this->Form->create(
			'Comment',
			array('url' => array(
				'controller' => Inflector::pluralize($artifact_type),
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
