<?php

class Observer_CapitaliseTitle extends \Orm\Observer
{
	
	public function before_save(Orm\Model $model)
	{

		$model->title = ucfirst(Str::lower($model->title));

	}

}