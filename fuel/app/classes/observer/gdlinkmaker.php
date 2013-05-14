<?php

class Observer_GDLinkMaker extends \Orm\Observer
{
	
	public function before_insert(Orm\Model $model)
	{

		switch (get_class( $model )){
		
			case 'Model_User':

				$url = \Uri::create( '/profile/'.$model->slug );

			break;

			case 'Model_Post':

				$url = \Uri::create('#'.$model->id.'-'.$model->slug );

			break;

		}



		try {

			$response 	= GDMetrics\Client::shorten_url( $url );

			$model->gdlink = 'http://gdlnk.co/'.$response['link']['slug'];

		}
		catch(GDMetrics\Exception $e) {

			Log\Log::error('GDMetrics - ' . $e->getMessage());

		}

	}

}