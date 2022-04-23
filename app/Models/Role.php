<?php

namespace App\Models;

use Trebol\Entrust\Contracts\EntrustRoleInterface;
use Trebol\Entrust\Traits\EntrustRoleTrait;

/**
 * @method static join(string $string, string $string1, string $string2, string $string3)
 * @method static find($role_id)
 */
class Role extends BaseModel implements EntrustRoleInterface
{
    use EntrustRoleTrait;

    protected $table = 'roles';

    protected $default = ['xid', 'id', 'name', 'display_name'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['id'];

    protected $appends = ['xid'];
}
