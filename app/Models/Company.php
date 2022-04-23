<?php

namespace App\Models;

use App\Casts\Hash;
use App\Classes\Common;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static first()
 */
class Company extends BaseModel
{
    protected $table = 'companies';

    protected $default = ['xid'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'currency_id', 'warehouse_id', 'created_at', 'updated_at'];

    protected $appends = ['xid', 'x_currency_id', 'x_warehouse_id', 'light_logo_url', 'dark_logo_url', 'small_light_logo_url', 'small_dark_logo_url', 'beep_audio_url'];

    protected $hashableGetterFunctions = [
        'getXCurrencyIdAttribute' => 'currency_id',
        'getXWarehouseIdAttribute' => 'warehouse_id',
    ];

    protected $casts = [
        'warehouse_id' => Hash::class . ':hash',
        'currency_id' => Hash::class . ':hash',
    ];

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getLightLogoUrlAttribute(): string
    {
        $companyLogoPath = Common::getFolderPath('companyLogoPath');

        return $this->light_logo == null ? asset('images/light.png') : Common::getFileUrl($companyLogoPath, $this->light_logo);
    }

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getDarkLogoUrlAttribute(): string
    {
        $companyLogoPath = Common::getFolderPath('companyLogoPath');

        return $this->dark_logo == null ? asset('images/dark.png') : Common::getFileUrl($companyLogoPath, $this->dark_logo);
    }

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getSmallDarkLogoUrlAttribute(): string
    {
        $companyLogoPath = Common::getFolderPath('companyLogoPath');

        return $this->small_dark_logo == null ? asset('images/small_dark.png') : Common::getFileUrl($companyLogoPath, $this->small_dark_logo);
    }

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getSmallLightLogoUrlAttribute(): string
    {
        $companyLogoPath = Common::getFolderPath('companyLogoPath');

        return $this->small_light_logo == null ? asset('images/small_light.png') : Common::getFileUrl($companyLogoPath, $this->small_light_logo);
    }

    public function getBeepAudioUrlAttribute(): string
    {
        $audioFilesPath = Common::getFolderPath('audioFilesPath');

        return asset($audioFilesPath . 'beep.wav');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
