<?php /** @noinspection RedundantSuppression */

/** @noinspection RedundantSuppression */

namespace App\Models;


use App\Classes\Common;

class Brand extends BaseModel
{
    protected $table = 'brands';

    protected $default = ['xid', 'name'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['xid', 'image_url'];

    protected $hidden = ['id'];

    protected $filterable = ['name'];

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getImageUrlAttribute(): string
    {
        $brandLogoPath = Common::getFolderPath('brandImagePath');

        return $this->image == null ? asset('images/brand.png') : Common::getFileUrl($brandLogoPath, $this->image);
    }
}
