<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaseModel extends Model
{
    use SoftDeletes; // สำคัญ: ให้ delete() เป็น Soft Delete (อัปเดต deleted_at)

    protected $table = 'leases';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'room_id',
        'start_date',
        'end_date',
        'rent_amount',
        'deposit_amount',
        'status',
        'contract_file_url',
    ];

    protected $casts = [
        'start_date'     => 'date',
        'end_date'       => 'date',
        'rent_amount'    => 'decimal:2',
        'deposit_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(UsersModel::class, 'user_id', 'id');
    }

    public function room()
    {
        return $this->belongsTo(RoomModel::class, 'room_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(InvoiceModel::class, 'lease_id', 'id');
    }

    // ใช้เช็คว่ามีใบแจ้งหนี้ค้างชำระอยู่หรือไม่
    public function hasUnpaidInvoices(): bool
    {
        return $this->invoices()->unpaid()->exists();
    }
}
