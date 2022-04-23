<?php

namespace App\Models;

use App\Classes\Common;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Trebol\Entrust\Traits\EntrustUserTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @method static select(string $string, string $string1, string $string2)
 * @method static withoutGlobalScope(string $string)
 */
class Customer extends BaseModel implements AuthenticatableContract, JWTSubject
{
    use Notifiable, EntrustUserTrait, Authenticatable, HasFactory;

    protected $table = 'users';

    protected $default = ["xid", "name", "profile_image"];

    protected $guarded = ['id', 'warehouse_id', 'opening_balance', 'opening_balance_type', 'credit_limit', 'credit_period', 'role_id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'role_id', 'password', 'remember_token'];

    protected $appends = ['xid', 'profile_image_url'];

    protected $filterable = ['name', 'user_type', 'email', 'status', 'phone'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('users.user_type', '=', 'customers');
        });
    }

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function setUserTypeAttribute($value)
    {
        $this->attributes['user_type'] = 'customers';
    }

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getProfileImageUrlAttribute(): string
    {
        $userImagePath = Common::getFolderPath('userImagePath');

        return $this->profile_image == null ? asset('images/user.png') : Common::getFileUrl($userImagePath, $this->profile_image);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function details(): HasOne
    {
        return $this->hasOne(UserDetails::class, 'user_id', 'id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
