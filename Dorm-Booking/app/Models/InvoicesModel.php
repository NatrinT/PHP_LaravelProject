<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicesModel extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['lease_id', 'billing_period', 'due_date', 'amount_rent','amount_utilities','amount_other','total_amount','status','paid_at','payment_status','receipt_file_url','create_at','update_at'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;
}
