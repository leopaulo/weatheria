<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Http\Services\CityListService;

class GetNearbyPlaceRequest extends FormRequest
{
    private $cityListService; 

    public function __construct(CityListService $cityListService) {
        $this->cityListService = $cityListService;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city' => 'required'
        ];
    }

    /**
	 * Configure the validator instance.
	 *
	 * @param  \Illuminate\Validation\Validator  $validator
	 * @return void
	 */
	public function withValidator($validator)
	{
		$validator->after(function ($validator) {
			if (count($validator->failed()) <= 0) {
                $cityList = $this->cityListService->getAll();

				if(!in_array(strtolower($this->city), $cityList)) {
                    $validator->errors()->add('city', 'Not a valid city name in japan');
                }
			}
		});
	}


}
