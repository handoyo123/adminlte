<?php /** @noinspection RedundantSuppression */

namespace App\Models;

use App\Casts\Hash;
use App\Classes\Common;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static select(string $string)
 */
class Expense extends BaseModel
{
    protected $table = 'expenses';

    protected $default = ['xid'];

    protected $guarded = ['id', 'warehouse_id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'warehouse_id', 'user_id', 'expense_category_id'];

    protected $appends = ['xid', 'x_warehouse_id', 'x_user_id', 'x_expense_category_id', 'bill_url'];

    protected $filterable = ['warehouse_id', 'expense_category_id', 'user_id'];

    protected $hashableGetterFunctions = [
        'getXUserIdAttribute' => 'user_id',
        'getXWarehouseIdAttribute' => 'warehouse_id',
        'getXExpenseCategoryIdAttribute' => 'expense_category_id',
    ];

    protected $casts = [
        'warehouse_id' => Hash::class . ':hash',
        'user_id' => Hash::class . ':hash',
        'expense_category_id' => Hash::class . ':hash',
    ];

    /** @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function getBillUrlAttribute(): ?string
    {
        $expenseBillPath = Common::getFolderPath('expenseBillPath');

        return $this->bill == null ? null : Common::getFileUrl($expenseBillPath, $this->bill);
    }

    public function expenseCategory(): HasOne
    {
        return $this->hasOne(ExpenseCategory::class, 'id', 'expense_category_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function warehouse(): HasOne
    {
        return $this->hasOne(Warehouse::class, 'id', 'warehouse_id');
    }
}
