<?php

namespace App\Http\Requests\Admin;

use App\Http\Services\ActualShipmentService;
use App\Models\ActualShipment;
use App\Models\Vehicle;
use Illuminate\Foundation\Http\FormRequest;

class ActualShipmentRequest extends FormRequest
{
    protected $actualShipmentService;

    public function __construct(ActualShipmentService $actualShipmentService)
    {
        $this->actualShipmentService = $actualShipmentService;
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
            "vehicle_id" => "required",
            "driver_id" => "required",
        ];

        if ($this->isMethod('post')) {
            $rules ['branch_id'] = "required";
            $rules ['from'] = "required";
            $rules ['to'] = "required|different:from";
            $rules ['from_time'] = "required";
            $rules ['to_time'] = "required|date|after_or_equal:from_time";
            $rules ['from_hour'] = "required";
            $rules ['to_hour'] = "required";
            $rules ['cutoff'] = "required";
            $rules ['cutoff_time'] = "required";
        }

        foreach (config()->get("app.locales") as $key => $lang) {
            $rules[$key.".*"] = "required" ;
        }

        if ($this->filled('parent_id') && $this->filled('vehicle_id')) {
            $parentShipment = ActualShipment::find($this->get('parent_id'));
            $parentShipmentCapacity = $parentShipment->capacity;
            $vehicle = Vehicle::find($this->get('vehicle_id'));

            $rules["vehicle_id"] = function ($attribute, $value, $fail) use ($parentShipment, $vehicle, $parentShipmentCapacity) {
                if ($this->actualShipmentService->calculateChildrenCapacity($parentShipment) + $vehicle->capacity > $parentShipmentCapacity) {
                    $fail(trans('overloaded_capacity'));
                }
            };

            $rules["to_time"] = function ($attribute, $value, $fail) use ($parentShipment) {
                $fromTime = $this->request->get('from_time') . " " . $this->request->get('from_hour');
                if (!$this->actualShipmentService->validateSubShipmentTime($fromTime, $parentShipment->to_time)) {
                    $fail(trans('sub_shipment_from_time_less_than_parent_to_time'));
                }
            };
        }

        return $rules ;
    }
}
