<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Urldetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'urldetail';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['urllistid', 'url', 'title', 'h1', 'metadesc', 'latitude', 'longitude', 'location', 'keywords'];
}
