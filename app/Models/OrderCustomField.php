<?php

namespace App\Models;

class OrderCustomField extends BaseModel
{
    public $timestamps = false;
    protected $table = 'order_custom_fields';
    protected $default = ['xid', 'field_name'];

    protected $guarded = ['id'];

    protected $hidden = ['id'];

    protected $appends = ['xid'];

    protected $filterable = ['field_name'];
}
