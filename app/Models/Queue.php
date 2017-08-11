<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Queue  extends Model
{
	 protected $table = 'queue';
	protected $fillable = [
        'queueNo','nric', 'status', 'caseref'
    ];

    protected $enumStatuses = [
        'AV' => 'Available',
        'P' => 'Pending',
        'IP' => 'InProgress',
        'AVM' => 'AvailableMP',
        'PM' => 'PendingM',
        'IPM' => 'InProgressMP',
        'C' => 'Closed',
    ];
}
