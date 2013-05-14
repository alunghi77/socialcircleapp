<?php

/**
 * Pusher Chat Observer
 *
 */
class Observer_PusherChat extends \Orm\Observer
{
	
	public function after_insert(\Orm\Model $obj)
	{
		$chats 	= Model_Chat::query()
					->related('user')
					->where('id',$obj->id)
					->order_by('created_at','desc');

		if (!($chatdata = $chats->get()))
			return parent::error('Not found.', 404);

		foreach( $chatdata as $chat ){

			$results = array(

				'id' => $chat->id,
				'message' => $chat->message,
				'posted_by' =>  array(
					'name' 		=> $chat->user->profile_fields['name'],
					'user_id' 	=> $chat->user->id,
					'fb_id' 	=> $chat->user->profile_fields['fb_id'],
					'profile_pic_url' => $chat->user->profile_fields['profile_pic'],
				),
				'created_at' => Date::time_ago($chat->created_at)

			);
		}

		\Pusherapp::forge()->trigger('converse_chat', 'send_chat', $results);
	}

}