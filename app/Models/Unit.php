<?php

namespace App\Models;

use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;

/**
 * @method static find(HigherOrderBuilderProxy|mixed $unit_id)
 * @method static select(string $string, string $string1, string $string2, string $string3, string $string4)
 */
class Unit extends BaseModel
{
    protected $table = 'units';

    protected $default = ['xid', 'name', 'short_name', 'operator', 'operator_value'];

    protected $guarded = ['id', 'is_deletable', 'created_at', 'updated_at'];

    protected $filterable = ['name'];

    protected $hidden = ['id', 'parent_id'];

    protected $appends = ['xid'];
}
