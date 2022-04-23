<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Hash implements CastsInboundAttributes
{
	/**
	 * The hashing algorithm.
	 *
	 * @var string
	 */
	protected $algorithm;

	/**
	 * Create a new cast class instance.
	 *
	 * @param string|null $algorithm
	 * @return void
	 */
	public function __construct(string $algorithm = null)
	{
		$this->algorithm = $algorithm;
	}

	/**
	 * Prepare the given value for storage.
	 *
	 * @param  Model  $model
	 * @param string $key
	 * @param  array  $value
	 * @param array $attributes
	 * @return string
	 */
	public function set($model, string $key, $value, array $attributes)
	{
		if ($value && !is_int($value)) {
			$newValue = Hashids::decode($value);
			$value = $newValue[0];
		}

		return $value;
	}
}
