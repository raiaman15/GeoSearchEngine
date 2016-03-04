<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invertedindex extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invertedindex';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['keyword', 'docid'];
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
}