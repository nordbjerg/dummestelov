<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Section extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'section';
	
	public function comments()
	{
		return $this->hasMany('Comment');
	}

	public function law()
	{
		return $this->belongsTo('Law');
	}

}