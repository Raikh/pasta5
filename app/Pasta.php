<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasta extends Model
{
    protected $table = 'pasta';

    protected $fillable = [
	'user_id',
	'body',
	'lang_id',
	'is_listed',
	'is_private',
	'hash',
	'updated_at',
	'created_at'
    ];

    public static function boot()
    {
	parent::boot();
	self::creating(function ($model) {
		$model->hash = strtolower(str_random(32));
	});
    }
}
