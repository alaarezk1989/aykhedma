<?php

namespace App\Http\Services;

use App\Models\Segmentation;
use Symfony\Component\HttpFoundation\Request;

class SegmentationService
{
    public function fillFromRequest(Request $request, $segmentation = null)
    {
        if (!$segmentation) {
            $segmentation = new Segmentation();
        }

        $segmentation->fill($request->request->all());

        $segmentation->save();

        return $segmentation;
    }
}
