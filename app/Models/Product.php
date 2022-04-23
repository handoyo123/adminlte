<?php /** @noinspection RedundantSuppression */

namespace App\Models;

use App\Casts\Hash;
use App\Classes\Common;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static select(string $string)
 * @method static where(string $string, mixed $id)
 * @method static find($product_id)
 */
class Product extends BaseModel
{
    protected $table = 'products';

    protected $default = ['xid'];

    protected $guarded = ['id', 'user_id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'category_id', 'brand_id', 'unit_id', 'user_id'];

    protected $appends = ['xid', 'x_category_id', 'x_brand_id', 'x_unit_id', 'x_user_id', 'image_url'];

    protected $filterable = ['id', 'products.id', 'name', 'category_id', 'brand_id'];

    protected $hashableGetterFunctions = [
        'getXCategoryIdAttribute' => 'category_id',
        'getXBrandIdAttribute' => 'brand_id',
        'getXUnitIdAttribute' => 'unit_id',
        'getXUserIdAttribute' => 'user_id',
    ];

    protected $casts = [
        'category_id' => Hash::class . ':hash',
        'brand_id' => Hash::class . ':hash',
        'unit_id' => Hash::class . ':hash',
        'user_id' => Hash::class . ':hash',
    ];

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getImageUrlAttribute(): string
    {
        $productImagePath = Common::getFolderPath('productImagePath');

        return $this->image == null ? asset('imagess/product.png') : Common::getFileUrl($productImagePath, $this->image);
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function brand(): HasOne
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function unit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function warehouseStocks(): HasMany
    {
        return $this->hasMany(WarehouseStock::class, 'product_id', 'id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }

    public function stockHistory(): HasMany
    {
        return $this->hasMany(StockHistory::class, 'product_id', 'id');
    }

    public function customFields(): HasMany
    {
        return $this->hasMany(ProductCustomField::class, 'product_id', 'id');
    }

    public function details(): HasOne
    {
        return $this->hasOne(ProductDetails::class);
    }

    // Start - Hashable Getter Functions
    // public function getXCategoryIdAttribute()
    // {
    // 	$value = $this->category_id;

    // 	if ($value) {
    // 		$value = Hashids::encode($value);
    // 	}

    // 	return $value;
    // }

    // public function getXBrandIdAttribute()
    // {
    // 	$value = $this->brand_id;

    // 	if ($value) {
    // 		$value = Hashids::encode($value);
    // 	}

    // 	return $value;
    // }

    // public function getXTaxIdAttribute()
    // {
    // 	$value = $this->tax_id;

    // 	if ($value) {
    // 		$value = Hashids::encode($value);
    // 	}

    // 	return $value;
    // }

    // public function getXUnitIdAttribute()
    // {
    // 	$value = $this->unit_id;

    // 	if ($value) {
    // 		$value = Hashids::encode($value);
    // 	}

    // 	return $value;
    // }

    // public function getXUserIdAttribute()
    // {
    // 	$value = $this->user_id;

    // 	if ($value) {
    // 		$value = Hashids::encode($value);
    // 	}

    // 	return $value;
    // }

    // End - Hashable Getter Functions
}
