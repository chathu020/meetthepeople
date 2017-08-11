<?php namespace  App\Models;

use Illuminate\Database\Eloquent\Model;

class Approvalparty extends Model
{
	protected $table = 'approvalparties';
	protected $fillable = [
        'authorizedName','designation', 'default'
    ];
}