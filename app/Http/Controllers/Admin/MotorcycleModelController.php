<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MotorcycleModel;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MotorcycleModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MotorcycleModel::with('brand');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter by brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->input('brand_id'));
        }

        // Filter by status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->input('is_active') == '1');
        }

        $motorcycleModels = $query->orderBy('name')->paginate(20);

        // Get brands for filter dropdown
        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        return view('admin.motorcycle-models.index', compact('motorcycleModels', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where('is_active', true)->orderBy('name')->pluck('name', 'id');

        return view('admin.motorcycle-models.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'year_from' => 'nullable|integer|min:1900|max:' . (date('Y') + 2),
            'year_to' => 'nullable|integer|min:1900|max:' . (date('Y') + 2),
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['brand_id', 'name', 'year_from', 'year_to', 'is_active']);
        $data['is_active'] = $request->boolean('is_active');

        MotorcycleModel::create($data);

        return redirect()
            ->route('admin.motorcycle-models.index')
            ->with('success', 'مدل موتورسیکلت با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MotorcycleModel $motorcycleModel)
    {
        return view('admin.motorcycle-models.show', compact('motorcycleModel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MotorcycleModel $motorcycleModel)
    {
        $brands = Brand::where('is_active', true)->orderBy('name')->pluck('name', 'id');

        return view('admin.motorcycle-models.edit', compact('motorcycleModel', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MotorcycleModel $motorcycleModel)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'year_from' => 'nullable|integer|min:1900|max:' . (date('Y') + 2),
            'year_to' => 'nullable|integer|min:1900|max:' . (date('Y') + 2),
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['brand_id', 'name', 'year_from', 'year_to', 'is_active']);
        $data['is_active'] = $request->boolean('is_active');

        $motorcycleModel->update($data);

        return redirect()
            ->route('admin.motorcycle-models.edit', $motorcycleModel)
            ->with('success', 'مدل موتورسیکلت با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MotorcycleModel $motorcycleModel)
    {
        // Check if model is used in any products
        if ($motorcycleModel->products()->exists()) {
            return redirect()
                ->route('admin.motorcycle-models.index')
                ->with('error', 'nemitan model ra hazf konid chon dar mahsulat estefade shode ast.');
        }

        $motorcycleModel->delete();

        return redirect()
            ->route('admin.motorcycle-models.index')
            ->with('success', 'مدل موتورسیکلت با موفقیت حذف شد.');
    }
}