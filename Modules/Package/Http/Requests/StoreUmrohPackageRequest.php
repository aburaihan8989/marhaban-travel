<?php

namespace Modules\Package\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreUmrohPackageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'package_name' => ['required', 'string', 'max:255'],
            // // 'package_code' => ['required', 'string', 'max:255'],
            // // 'package_code' => ['required', 'string', 'max:255', 'unique:umroh_packages,package_code'],
            // // 'product_barcode_symbology' => ['required', 'string', 'max:255'],
            // 'package_capacity' => ['required', 'integer'],
            // 'package_departure' => ['required', 'string', 'max:255'],
            // 'package_days' => ['required', 'string', 'max:255'],
            // 'package_date' => ['required'],
            // 'flight_route' => ['required', 'string', 'max:255'],
            // 'package_type' => ['required', 'string', 'max:255'],
            // 'hotel_makkah' => ['required', 'string', 'max:255'],
            // 'hotel_madinah' => ['required', 'string', 'max:255'],
            // 'package_cost' => ['required', 'numeric'],
            // 'package_price' => ['required', 'numeric'],
            // 'package_include' => ['nullable', 'string'],
            // 'package_exclude' => ['nullable', 'string'],
            // 'package_term' => ['nullable', 'string']
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return Gate::allows('create_products');
    }
}
