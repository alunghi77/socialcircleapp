<?php

class Observer_MediaObjectEncode extends \Orm\Observer
{
	
	public function before_save(Orm\Model $model)
	{

		$model->object = Format::forge($model->object)->to_json();
		$model->object = base64_encode($model->object);

	}

	public function after_load(Orm\Model $model)
	{

		$model->object = base64_decode($model->object);
		$model->object = Format::forge($model->object, 'json')->to_array();

	}

	public function after_save(Orm\Model $model)
	{

		$this->after_load($model);

	}

}