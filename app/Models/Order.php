<?php

namespace App\Models;

use App\Casts\Hash;
use App\Classes\Common;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Expression;

/**
 * @method static find(mixed $id)
 * @method static where(string $string, mixed $userId)
 * @method static select(Expression $raw)
 * @method static max(string $string)
 */
class Order extends BaseModel
{
    protected $table = 'orders';

    protected $default = ['xid'];

    protected $guarded = ['id', 'warehouse_id', 'staff_user_id', 'order_type', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'warehouse_id', 'user_id', 'tax_id', 'staff_user_id', 'cancelled_by'];

    protected $appends = ['xid', 'x_warehouse_id', 'x_user_id', 'x_tax_id', 'x_staff_user_id', 'x_cancelled_by', 'document_url'];

    protected $dates = ['order_date'];

    protected $filterable = ['id', 'invoice_number', 'payment_status', 'order_status', 'cancelled', 'order_date', 'user_id'];

    protected $hashableGetterFunctions = [
        'getXWarehouseIdAttribute' => 'warehouse_id',
        'getXUserIdAttribute' => 'user_id',
        'getXTaxIdAttribute' => 'tax_id',
        'getXStaffUserIdAttribute' => 'staff_user_id',
        'getXCancelledByAttribute' => 'cancelled_by',
    ];

    protected $casts = [
        'warehouse_id' => Hash::class . ':hash',
        'user_id' => Hash::class . ':hash',
        'tax_id' => Hash::class . ':hash',
        'cancelled_by' => Hash::class . ':hash',
    ];

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getDocumentUrlAttribute(): string
    {
        $orderDocumentPath = Common::getFolderPath('orderDocumentPath');

        return $this->image == null ? asset('images/order.png') : Common::getFileUrl($orderDocumentPath, $this->image);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function orderPayments(): HasMany
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id')->withoutGlobalScope('type');
    }

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class, 'id', 'user_id');
    }

    public function staffMember(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'staff_user_id');
    }

    public function warehouse(): HasOne
    {
        return $this->hasOne(Warehouse::class, 'id', 'warehouse_id');
    }

    public function tax(): HasOne
    {
        return $this->hasOne(Tax::class, 'id', 'tax_id');
    }

    public function shippingAddress(): HasOne
    {
        return $this->hasOne(OrderShippingAddress::class, 'order_id', 'id');
    }
}
