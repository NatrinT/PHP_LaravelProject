<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'lease_id',
        'billing_period',
        'due_date',
        'amount_rent',
        'amount_utilities',
        'amount_other',
        'total_amount',
        'status',           // DRAFT | ISSUED | PAID | OVERDUE | CANCELED
        'payment_status',   // PENDING | CONFIRMED | FAILED
        'paid_at',
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

    /**
     * Scope: ใบแจ้งหนี้ที่ "ยังไม่จ่าย"
     * นิยามว่าเป็นบิลที่:
     *  - status ยังอยู่ใน DRAFT/ISSUED/OVERDUE (ยังไม่เป็น PAID/CANCELED)
     *    หรือ
     *  - payment_status ไม่ใช่ CONFIRMED (หรือเป็น NULL)
     */
    public function scopeUnpaid($q)
    {
        return $q->where(function ($w) {
            $w->whereIn('status', ['DRAFT', 'ISSUED', 'OVERDUE'])
              ->orWhereNull('payment_status')
              ->orWhere('payment_status', '!=', 'CONFIRMED');
        });
    }
}
