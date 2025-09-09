<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true; // ใช้ได้เลย

    protected $fillable = [
        'lease_id',
        'billing_period',
        'due_date',
        'amount_rent',
        'amount_utilities',
        'amount_other',
        'total_amount',
        'status',
        'paid_at',
        'payment_status',
        'receipt_file_url',
    ];

    protected $casts = [
        'due_date'         => 'date',
        'paid_at'          => 'datetime',
        'amount_rent'      => 'decimal:2',
        'amount_utilities' => 'decimal:2',
        'amount_other'     => 'decimal:2',
        'total_amount'     => 'decimal:2',
    ];

    public function lease()
    {
        return $this->belongsTo(LeaseModel::class, 'lease_id', 'id');
    }
}

