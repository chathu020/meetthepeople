<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Postalcode  extends Model
{
	protected $fillable = [
        'code','description'
    ];
}