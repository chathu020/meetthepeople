<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Client  extends Model
{
	protected $fillable = [
        'nric','name','color', 'blkNo', 'unitNo', 'address', 'postalCode',
        'sex', 'race', 'homeTel', 'pagerNo', 'officeTel', 'handphone', 
        'accomodationType', 'roomType', 'status', 'dateOfBirth', 'noContact', 'language','notes',
        'preferred','resident','email'
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accomodation::Class, 'roomType');
    }
    
    public function caseFiles()
    {
        return $this->belongsTo('CaseFile');
    }
}
