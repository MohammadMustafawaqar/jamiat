<?php

namespace App\Models;

use App\Models\Jamiat\Grade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable = ['address_type_id','province_id', 'district_id', 'name', 'details', 'village'];

    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'school_grades');
    }
}
