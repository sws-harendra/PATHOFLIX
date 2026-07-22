<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CultureResult extends Model
{
    protected $fillable = [
        'test_report_id',
        'invoice_item_id',
        'lab_test_id',
        'specimen',
        'growth_status',
        'incubation_period',
        'organism_name',
        'colony_count',
        'remarks'
    ];

    public function getLabTestIdAttribute($value)
    {
        return (!empty($value) && is_numeric($value)) ? (int)$value : null;
    }

    public function setLabTestIdAttribute($value)
    {
        $this->attributes['lab_test_id'] = (!empty($value) && is_numeric($value)) ? (int)$value : null;
    }

    public function testReport()
    {
        return $this->belongsTo(TestReport::class);
    }

    public function invoiceItem()
    {
        return $this->belongsTo(InvoiceItem::class);
    }

    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }

    public function antibiotics()
    {
        return $this->hasMany(CultureAntibiotic::class);
    }
}
