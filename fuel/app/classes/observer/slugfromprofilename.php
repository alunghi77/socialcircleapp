<?php

class Observer_SlugFromProfileName extends \Orm\Observer
{
	
	public function before_save(Orm\Model $model)
	{

		$profile_fields = unserialize($model->profile_fields);

		$model->slug = Str::lower( Inflector::friendly_title( $profile_fields['name'] ) );

	}

}