<?php

namespace App\Models;

use App\Casts\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static withoutGlobalScope(string $string)
 */
class ProductDetails extends BaseModel
{
    protected $table = 'product_details';

    protected $default = ['xid'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'warehouse_id', 'product_id', 'tax_id'];

    protected $appends = ['xid', 'x_warehouse_id', 'x_product_id', 'x_tax_id'];

    protected $filterable = ['id'];

    protected $hashableGetterFunctions = [
        'getXWarehouseIdAttribute' => 'warehouse_id',
        'getXProductIdAttribute' => 'product_id',
        'getXTaxIdAttribute' => 'tax_id',
    ];

    protected $casts = [
        'warehouse_id' => Hash::class . ':hash',
        'product_id' => Hash::class . ':hash',
        'tax_id' => Hash::class . ':hash',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('current_warehouse', function (Builder $builder) {
            $warehouse = warehouse();

            if ($warehouse) {
                $builder->where('product_details.warehouse_id', $warehouse->id);
            }
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }
}
