<?php

namespace App\Models;

use App\Casts\Hash;
use App\Classes\Common;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, mixed $id)
 */
class Category extends BaseModel
{
    protected $table = 'categories';

    protected $default = ['id', 'xid', 'name', 'slug', 'parent_id', 'x_parent_id', 'image'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'parent_id'];

    protected $appends = ['xid', 'x_parent_id', 'image_url'];

    protected $filterable = ['id', 'name', 'slug', 'parent_id'];

    protected $hashableGetterFunctions = [
        'getXParentIdAttribute' => 'parent_id',
        'getXWarehouseIdAttribute' => 'warehouse_id',
    ];

    protected $casts = [
        'parent_id' => Hash::class . ':hash',
    ];

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getImageUrlAttribute(): string
    {
        $categoryLogoPath = Common::getFolderPath('categoryImagePath');

        return $this->image == null ? asset('images/category.png') : Common::getFileUrl($categoryLogoPath, $this->image);
    }

    public function childs(): HasMany
    {
        return $this->subcategories()->with('childs');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
