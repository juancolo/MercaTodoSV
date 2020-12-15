<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Report\ReportManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.reports.index');
    }

    public function show(Request $request, string $reportSlug): JsonResponse
    {
        $report= config('reports.'.$reportSlug) ?? abort(404);

        $filter = json_decode($request->get('filter'), true) ?? [];

        $data = (new ReportManager(new $report['behavior']()))->read($filter);

        return response()->json([
           'report' => $data
        ]);
    }
}
