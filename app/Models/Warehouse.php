<?php /** @noinspection RedundantSuppression */

/** @noinspection RedundantSuppression */

namespace App\Models;

use App\Classes\Common;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

/**
 * @method static select(string $string)
 * @method static find(mixed $getIdFromHash)
 */
class Warehouse extends BaseModel
{
    use Notifiable;

    protected $table = 'warehouses';

    protected $default = ['xid', 'name'];

    protected $guarded = ['id', 'users', 'created_at', 'updated_at'];

    protected $hidden = ['id'];

    protected $appends = ['xid', 'logo_url', 'signature_url'];

    protected $filterable = ['name', 'email', 'phone', 'city', 'country', 'zipcode'];

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getLogoUrlAttribute(): string
    {
        $warehouseLogoPath = Common::getFolderPath('warehouseLogoPath');

        return $this->logo == null ? asset('images/warehouse.png') : Common::getFileUrl($warehouseLogoPath, $this->logo);
    }

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getSignatureUrlAttribute(): ?string
    {
        $warehouseLogoPath = Common::getFolderPath('warehouseLogoPath');

        return $this->signature == null ? null : Common::getFileUrl($warehouseLogoPath, $this->signature);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
