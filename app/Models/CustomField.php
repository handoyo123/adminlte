<?php

namespace App\Models;

class CustomField extends BaseModel
{
    public $timestamps = false;
    protected $table = 'custom_fields';
    protected $default = ['xid', 'name'];

    protected $guarded = ['id'];

    protected $hidden = ['id'];

    protected $appends = ['xid'];

    protected $filterable = ['name'];
}
