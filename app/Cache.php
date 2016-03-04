<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cache extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cachetable';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['search_query', 'doc_title', 'doc_url', 'doc_keywords', 'occurrence'];
}
