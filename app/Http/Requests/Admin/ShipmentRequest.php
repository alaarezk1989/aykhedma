<?php

namespace App\Http\Requests\Admin;

use App\Constants\RecurringTypes;
use App\Http\Services\ShipmentService;
use App\Models\Shipment;
use App\Models\Vehicle;
use Illuminate\Foundation\Http\FormRequest;

class ShipmentRequest extends FormRequest
{
    protected $shipmentService;

    public function __construct(ShipmentService $shipmentService)
    {
        $this->shipmentService = $shipmentService;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "branch_id" => "required",
            "vehicle_id" => "required",
            "driver_id" => "required",
            "from" => "required",
            "to" => "required|different:from",
        ];

        if ($this->isMethod('post')) {
            $rules = [
                "branch_id" => "required",
                "vehicle_id" => "required",
                "driver_id" => "required",
                "from" => "required",
                "to" => "required|different:from",
                "from_time" => "required",
                "to_time" => "required|after:from_time",
                "cut_off_date" => "required",
            ];
            if (!$this->request->get('parent_id')) {
                $rules['recurring'] = 'required';
            }
        }

        if ($this->filled('parent_id') && $this->filled('vehicle_id')) {
            $parentShipment = Shipment::find($this->get('parent_id'));
            $parentShipmentCapacity = $parentShipment->capacity;
            $vehicle = Vehicle::find($this->get('vehicle_id'));

            $rules["vehicle_id"] = function ($attribute, $value, $fail) use ($parentShipment, $vehicle, $parentShipmentCapacity) {
                if ($this->shipmentService->calculateChildrenCapacity($parentShipment) + $vehicle->capacity > $parentShipmentCapacity) {
                    $fail(trans('overloaded_capacity'));
                    }
            };

            $rules["to_time"] = function ($attribute, $value, $fail) use ($parentShipment) {
                if (!$this->shipmentService->validateSubShipmentTime($this->get('from_time'), $parentShipment->to_time)) {
                    $fail(trans('sub_shipment_from_time_less_than_parent_to_time'));
                }
            };
        }

        if ($this->request->get('recurring') == RecurringTypes::MONTHLY || $this->request->get('recurring') == RecurringTypes::WEEKLY || $this->request->get('recurring') == RecurringTypes::ONE_TIME) {
            $rules['day'] = 'required';
        }

        foreach (config()->get("app.locales") as $key => $lang) {
            $rules[$key.".*"] = "required" ;
        }
        return $rules ;
    }
}
