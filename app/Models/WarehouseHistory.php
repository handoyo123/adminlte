<?php

namespace App\Models;

use App\Casts\Hash;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(Closure $param)
 */
class WarehouseHistory extends BaseModel
{
    public $timestamps = false;
    protected $table = 'warehouse_history';
    protected $dates = ['date', 'updated_at'];

    protected $default = ['xid'];

    protected $guarded = ['id'];

    protected $hidden = ['id', 'warehouse_id', 'user_id', 'product_id', 'order_id', 'payment_id', 'expense_id'];

    protected $appends = ['xid', 'x_warehouse_id', 'x_user_id', 'x_product_id', 'x_order_id', 'x_payment_id', 'x_expense_id'];

    protected $filterable = ['id', 'date', 'type', 'user_id'];

    protected $hashableGetterFunctions = [
        'getXWarehouseIdAttribute' => 'warehouse_id',
        'getXUserIdAttribute' => 'user_id',
        'getXProductIdAttribute' => 'product_id',
        'getXOrderIdAttribute' => 'order_id',
        'getXPaymentIdAttribute' => 'payment_id',
        'getXExpenseIdAttribute' => 'expense_id',
    ];

    protected $casts = [
        'warehouse_id' => Hash::class . ':hash',
        'user_id' => Hash::class . ':hash',
        'product_id' => Hash::class . ':hash',
        'order_id' => Hash::class . ':hash',
        'payment_id' => Hash::class . ':hash',
        'expense_id' => Hash::class . ':hash',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('current_warehouse', function (Builder $builder) {
            $warehouse = warehouse();

            if ($warehouse) {
                $builder->where('warehouse_history.warehouse_id', $warehouse->id);
            }
        });
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withoutGlobalScopes();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }
}
