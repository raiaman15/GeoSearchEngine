<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Urllist extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'urllist';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent', 'url', 'urltext', 'processed'];

}
