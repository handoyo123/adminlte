<?php

namespace App\Models;

/**
 * @method static where(string $string, string $string1)
 */
class PaymentMode extends BaseModel
{
    protected $table = 'payment_modes';

    protected $default = ['xid', 'name'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $filterable = ['name'];

    protected $hidden = ['id'];

    protected $appends = ['xid'];
}
