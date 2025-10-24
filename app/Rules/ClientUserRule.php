<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\ClientUser;


class ClientUserRule implements ValidationRule
{

    protected $user_id;

    /**
     * Create a new rule instance.
     *
     * @param  int|null  $ignoreId
     * @return void
     */
    public function __construct($user)
    {
        $this->user_id = $user->id;
    }


	/**
	 * Run the validation rule.
	 *
	 * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
	 */
	public function validate(string $attribute, mixed $value, Closure $fail): void
	{
		if ($attribute != 'client_id') {
			$fail("Wrong attribute.");
		}

		$cond = [];

		$cond['user_id'] = $this->user_id;
		$cond['client_id'] = $value;

		$query = ClientUser::where($cond);

		if (!$query->exists()) {
			$fail("This user is not associated to the client (:attribute).");
		}

	}
}
