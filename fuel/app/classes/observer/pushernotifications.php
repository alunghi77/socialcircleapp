<?php

/**
 * Pusher Notifications Observer
 *
 */
class Observer_PusherNotifications extends \Orm\Observer
{
	
	public function after_save(\Orm\Model $model)
	{
		# Get latest notification
		$notifications = Notifications\Query::get(null,null,$model->content_type,1,0,true, $model->id);
		
		\Pusherapp::forge()->trigger('converse_notifications', 'send_notification', isset($notifications[0]) ? $notifications[0] : $notifications );
	}

}