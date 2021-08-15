<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Models\Branch;
use Illuminate\Http\Request;
use View;

class SearchController extends BaseController
{
    public function search(Request $request)
    {
        if (!$request->query->get('activity') || !$request->query->get('zone')) {
            session()->flash('search_error', trans('search_error'));
            return redirect()->back();
        }

        $branches = Branch::select('branches.*')->join('vendors', 'vendors.id', '=', 'branches.vendor_id')
            ->where('vendors.activity_id', $request->query->get('activity'))->get();

        $currentBranch = $branches->first();

        if ($id = $request->query->get('branch')) {
            $currentBranch = Branch::find($id);
        }
        return View::make('web.search.result', ['branches' => $branches, 'currentBranch' => $currentBranch]);
    }
}