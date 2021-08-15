<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\ActualShipmentRepository;
use Illuminate\Http\Response as ResponseAlias;
use Illuminate\Routing\Controller;

class ShipmentsController extends Controller
{
    protected $actualShipmentRepository;
    public function __construct(ActualShipmentRepository $actualShipmentRepository)
    {
        $this->actualShipmentRepository = $actualShipmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ResponseAlias
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getModelData(Request $request)
    {
        $list = $request->get('modelClass')::all();
        return response()->json($list);
    }

    public function timeSlots(Request $request)
    {
        $list = $this->actualShipmentRepository->getTimeSlots($request->get('user_address'), $request->get('branch_id'), $request->get('load'))->get();

        return response()->json(['success'=>true, 'result' => $list]);
    }
}
