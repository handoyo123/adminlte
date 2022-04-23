<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

class getTransactionDb
{

    /**
     * @return void
     */
    public function getBeginTransaction(): void
    {
        DB::beginTransaction();
    }
}
