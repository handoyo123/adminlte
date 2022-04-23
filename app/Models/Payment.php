<?php /** @noinspection RedundantSuppression */

namespace App\Models;

use App\Casts\Hash;
use App\Classes\Common;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Expression;

/**
 * @property mixed $payment_number
 * @method static select(Expression $raw)
 * @method static where(string $string, string $string1)
 */
class Payment extends BaseModel
{
    protected $table = 'payments';

    protected $default = ['xid'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'payment_mode_id', 'user_id'];

    protected $appends = ['xid', 'x_payment_mode_id', 'x_user_id', 'file_url'];

    protected $filterable = ['id', 'payment_number', 'payment_type', 'user_id'];

    protected $hashableGetterFunctions = [
        'getXPaymentModeIdAttribute' => 'payment_mode_id',
        'getXUserIdAttribute' => 'user_id',
    ];

    protected $casts = [
        'payment_mode_id' => Hash::class . ':hash',
        'user_id' => Hash::class . ':hash',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('current_warehouse', function (Builder $builder) {
            $warehouse = warehouse();

            if ($warehouse) {
                $builder->where('payments.warehouse_id', $warehouse->id);
            }
        });
    }

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getFileUrlAttribute(): string
    {
        $purchaseDocumentPath = Common::getFolderPath('purchaseDocumentPath');

        return $this->file == null ? asset($purchaseDocumentPath . 'default.png') : asset($purchaseDocumentPath . $this->file);
    }

    public function paymentMode(): BelongsTo
    {
        return $this->belongsTo(PaymentMode::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withoutGlobalScopes();
    }
}
