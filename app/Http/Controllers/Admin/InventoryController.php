<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryLog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display the inventory dashboard.
     */
    public function index()
    {
        $products = Product::orderBy('name')->get();
        $inventoryLogs = InventoryLog::with('product')->latest()->paginate(20);
        $lowStockProducts = Product::where('stock', '<', 5)
            ->where('is_active', true)
            ->orderBy('stock')
            ->get();

        return view('admin.inventory.index', compact('products', 'inventoryLogs', 'lowStockProducts'));
    }

    /**
     * Adjust inventory for a product.
     */
    public function adjust(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'change_amount' => 'required|integer',
            'reason' => 'required|string|in:purchase,sale,adjustment,damage,return,correction',
            'note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::findOrFail($request->product_id);

        // Update product stock
        $product->stock += $request->change_amount;
        if ($product->stock < 0) {
            $product->stock = 0;
        }
        $product->save();

        // Create inventory log
        InventoryLog::create([
            'product_id' => $product->id,
            'change_amount' => $request->change_amount,
            'reason' => $request->reason,
            'note' => $request->note,
        ]);

        return redirect()
            ->route('admin.inventory.index')
            ->with('success', 'موجودی محصول با موفقیت به‌روزرسانی شد.');
    }
}
