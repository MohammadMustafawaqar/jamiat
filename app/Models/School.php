<?php

namespace App\Models;

use App\Models\Jamiat\Grade;
use App\Traits\CreatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory, CreatedBy;
    protected $fillable = ['address_type_id','province_id', 'district_id', 'name', 'details', 'village'];

    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'school_grades');
    }

    public function getAddressAttribute()
    {
        return $this->address_type_id === 1 ? $this->province?->name : $this->province?->name . ' - ' . $this->province?->country?->name;
    }
}
