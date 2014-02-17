<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

// TODO: Documents
class Section extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sections';
	
	public function comments()
	{
		return $this->hasMany('Comment');
	}

	public function law()
	{
		return $this->belongsTo('Law');
	}

	public function scopePopular($query)
	{
		return $query->orderBy('votes', 'desc');
	}

	public function getVotesAttribute($value)
	{
		$suffix = array('TD', 'M');
	    $result = '';

	    while ($value >= 1000
	    	&& count($suffix) > 0) {
	        $value = $value / 1000.0;
	        $result = array_shift($suffix);
	    }

	    return round($value, max(0, 3 - strlen($value))).$result;
	}

}