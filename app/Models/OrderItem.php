<?php

namespace App\Models;

use App\Casts\Hash;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Expression;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @method static select(string $string, Expression $raw)
 * @method static join(string $string, string $string1, string $string2, string $string3)
 * @method static find(mixed $removedOrderItem)
 */
class OrderItem extends BaseModel
{
    protected $table = 'order_items';

    protected $default = ['xid'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'order_id', 'user_id', 'product_id', 'unit_id', 'tax_id'];

    protected $appends = ['xid', 'x_order_id', 'x_user_id', 'x_product_id', 'x_unit_id', 'x_tax_id'];

    protected $filterable = ['id', 'product_id'];

    protected $casts = [
        'user_id' => Hash::class . ':hash',
        'order_id' => Hash::class . ':hash',
        'product_id' => Hash::class . ':hash',
        'unit_id' => Hash::class . ':hash',
        'tax_id' => Hash::class . ':hash',
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function unit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    // Start - Hashable Getter Functions

    /** @noinspection PhpUndefinedFieldInspection */
    public function getXUserIdAttribute()
    {
        $value = $this->user_id;

        if ($value) {
            $value = Hashids::encode($value);
        }

        return $value;
    }

    /** @noinspection PhpUndefinedFieldInspection */
    public function getXOrderIdAttribute()
    {
        $value = $this->order_id;

        if ($value) {
            $value = Hashids::encode($value);
        }

        return $value;
    }

    /** @noinspection PhpUndefinedFieldInspection */
    public function getXProductIdAttribute()
    {
        $value = $this->product_id;

        if ($value) {
            $value = Hashids::encode($value);
        }

        return $value;
    }

    /** @noinspection PhpUndefinedFieldInspection */
    public function getXUnitIdAttribute()
    {
        $value = $this->unit_id;

        if ($value) {
            $value = Hashids::encode($value);
        }

        return $value;
    }

    /** @noinspection PhpUndefinedFieldInspection */
    public function getXTaxIdAttribute()
    {
        $value = $this->tax_id;

        if ($value) {
            $value = Hashids::encode($value);
        }

        return $value;
    }

    // End - Hashable Getter Functions
}
