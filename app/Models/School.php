<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable = ['address_type_id', 'district_id', 'name', 'details'];

    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
