<?php

namespace App\Models;

use App\Classes\Common;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static select(string $string, string $string1, string $string2, string $string3)
 */
class Lang extends BaseModel
{
    protected $table = 'langs';

    protected $default = ['xid', 'name', 'key'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['id'];

    protected $appends = ['xid', 'image_url'];

    protected $filterable = ['name'];

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getImageUrlAttribute(): string
    {
        $langImagePath = Common::getFolderPath('langImagePath');

        return $this->image == null ? asset('images/lang.png') : Common::getFileUrl($langImagePath, $this->image);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class);
    }
}
