<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Casestatus  extends Model
{
	protected $table = 'casestatus';
	protected $fillable = [
        'subject','status', 'case_id', 'filename'
    ];
}
