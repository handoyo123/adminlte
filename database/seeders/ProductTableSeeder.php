<?php

namespace Database\Seeders;

use App\Models\CustomField;
use Examyou\RestAPI\Exceptions\RelatedResourceNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     * @throws RelatedResourceNotFoundException
     */

	public function run()
	{
		Model::unguard();

		DB::table('custom_fields')->delete();
		DB::table('products')->delete();

		DB::statement('ALTER TABLE custom_fields AUTO_INCREMENT = 1');
		DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');

		$customField = new CustomField();
		$customField->name = "Expiry Date";
		$customField->type = "date";
		$customField->save();
	}
}
