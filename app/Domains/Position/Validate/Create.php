<?php declare(strict_types=1);

namespace App\Domains\Position\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'serial' => ['bail', 'required', 'string'],
            'latitude' => ['bail', 'required', 'numeric'],
            'longitude' => ['bail', 'required', 'numeric'],
            'speed' => ['bail', 'required', 'numeric'],
            'direction' => ['bail', 'required', 'integer'],
            'signal' => ['bail', 'required', 'integer'],
            'date_utc_at' => ['bail', 'required', 'date_format:Y-m-d H:i:s'],
            'timezone' => ['bail', 'nullable'],
        ];
    }
}
