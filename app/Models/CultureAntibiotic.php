<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CultureAntibiotic extends Model
{
    protected $fillable = [
        'culture_result_id',
        'antibiotic_name',
        'sensitivity',
        'mic_value'
    ];

    public function cultureResult()
    {
        return $this->belongsTo(CultureResult::class);
    }
}
