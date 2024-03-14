<?php

namespace App\Http\Controllers;

use App\Models\HolidayPlan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class HolidayPlanController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }
    
    public function show($id)
    {
        $holidayPlan = HolidayPlan::find($id);
    
        if (!$holidayPlan) {
            return response()->json(['message' => 'Holiday plan not found']);
        }
        return response()->json(['info' => $holidayPlan]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'participants' => 'nullable|string',
        ]);
    
        try {
            $holidayPlan = HolidayPlan::create($request->all());
            return response()->json(['success' => 'Holiday plan created successfully', 'holiday_plan' => $holidayPlan], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create holiday plan: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'participants' => 'nullable|string',
        ]);

        $holidayPlan = HolidayPlan::find($id);

        if (!$holidayPlan) {
            return response()->json(['error' => 'Holiday plan not found'], 404);
        }

        try {
            $holidayPlan->update($request->all());
            return response()->json(['success' => 'Holiday plan updated successfully', 'holiday_plan' => $holidayPlan], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update holiday plan: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $holidayPlan = HolidayPlan::find($id);
    
        if (!$holidayPlan) {
            return response()->json(['error' => 'Holiday plan not found'], 404);
        }
    
        try {
            $holidayPlan->delete();
            return response()->json(['success' => 'Holiday plan deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete holiday plan: ' . $e->getMessage()], 500);
        }
    }

    public function generatePdf($id)
    {
        $holidayPlan = HolidayPlan::find($id);
    
        if (!$holidayPlan) {
            return response()->json(['message' => 'Holiday plan not found'], 404);
        }
        $pdf = PDF::loadView('pages.pdf', ['holidayPlan' => $holidayPlan]);
    
        return $pdf->download('holiday_plan_' . $id . '.pdf');
    }

    public function dataTable(Request $request)
    {
        $columns = [
            'id',
            'title',
            'description',
            'date',
            'location',
            'participants',
        ];

        $holidayPlanId = $request->input('id');

        if ($holidayPlanId) {
            $holidayPlan = HolidayPlan::find($holidayPlanId);
    
            if (!$holidayPlan) {
                return response()->json(['error' => 'Holiday plan not found'], 404);
            }
    
            return response()->json(['data' => $holidayPlan]);
        }
    
        $query = HolidayPlan::query();
    
        // Handle DataTables search
        if ($request->filled('search.value')) {
            $searchTerm = $request->input('search.value');
            $query->where(function ($subQuery) use ($columns, $searchTerm) {
                foreach ($columns as $column) {
                    $subQuery->orWhere($column, 'like', '%' . $searchTerm . '%');
                }
            });
        }
    
        // Handle DataTables ordering
        if ($request->filled('order.0.column') && $request->filled('order.0.dir')) {
            $orderColumn = $columns[$request->input('order.0.column')];
            $orderDirection = $request->input('order.0.dir');
            $query->orderBy($orderColumn, $orderDirection);
        }
    
        // Fetch only the required records for the current page
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $data = $query->offset($start)->limit($length)->get();
    
        $response = [
            'draw' => $request->input('draw', 1),
            'recordsTotal' => HolidayPlan::count(),
            'recordsFiltered' => $query->count(),
            'data' => $data,
        ];
    
        return $response;
    }

}
