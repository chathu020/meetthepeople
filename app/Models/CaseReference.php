<?php

namespace  App\Models;
use Illuminate\Database\Eloquent\Model;

class CaseReference extends Model
{
	protected $table = 'casereferences';
	
	protected $fillable = [
        'description', 'countera'
    ];

}