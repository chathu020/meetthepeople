<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CaseFile  extends Model
{
 protected $table = 'cases';
	protected $fillable = [
        'client_id','clientCaseRefHead', 'clientCaseRefTail','caseRef_id', 'approvedBy_id', 'refNo','recipient_id',
        'recipient_Name','recipient_Address','recipient_Salutation','attention','subject','content',
         'enclosed','cc', 'footer', 'writer_id','comment', 'queueno', 'deliverymode'
    ];

    public function client()
    {
        return $this->belongsTo(Client::Class, 'client_id');
    }
   
    public function caseReference()
    {
        return $this->belongsTo('App\Models\CaseReference', 'caseRef_id');
    }

    public function approvalparty()
    {
        return $this->belongsTo('App\Models\Approvalparty', 'approvedBy_id');
    }

    public function writer()
    {
        return $this->belongsTo('App\Models\User', 'writer_id');
    }
}
