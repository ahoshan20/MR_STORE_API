<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends BaseModel
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'village',
        'road_no',
        'house_no',
        'union',
        'post_office',
        'sub_district',
        'district',
        'division',
    ];
    // ################ Relations ################
    public function user()
    {
        return $this->morphTo();
    }
}
