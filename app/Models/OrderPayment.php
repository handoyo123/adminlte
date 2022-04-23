<?php

namespace App\Models;

use App\Casts\Hash;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, mixed $id)
 * @method static select(string $string)
 * @method static find(mixed $orderPaymentId)
 */
class OrderPayment extends BaseModel
{
    protected $table = 'order_payments';

    protected $default = ['xid'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'order_id', 'payment_id'];

    protected $appends = ['xid', 'x_order_id', 'x_payment_id', 'file_url'];

    protected $filterable = ['id', 'amount', 'orders.order_type', 'user_id', 'date', 'order_date', 'warehouse_id', 'user_id'];

    protected $hashableGetterFunctions = [
        'getXOrderIdAttribute' => 'order_id',
        'getXPaymentIdAttribute' => 'payment_id',
    ];

    protected $casts = [
        'order_id' => Hash::class . ':hash',
        'x_payment_id' => Hash::class . ':hash',
    ];

    // protected $filterable = ['id', 'amount', 'orders.order_type'];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
