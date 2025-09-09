<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaseModel extends Model
{
    protected $table = 'leases';
    protected $primaryKey = 'id';
    public $incrementing = true;

    // ในตารางมี created_at / updated_at อยู่แล้ว
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

    // ความสัมพันธ์ (ถ้ามีโมเดลเหล่านี้)
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
}
