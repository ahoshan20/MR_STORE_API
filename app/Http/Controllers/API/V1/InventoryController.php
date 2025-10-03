<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Get daily inventory report
     */
    // public function getDailyInventoryReport(Request $request)
    // {
    //     $date = $request->get('date', Carbon::today()->toDateString());
        
    //     // Movements for the day
    //     $movements = StockMovement::with([
    //         'product:id,name,name_bn',
    //         'eggType:id,name,name_bn',
    //         'unit:id,name,symbol'
    //     ])
    //     ->whereDate('created_at', $date)
    //     ->get()
    //     ->groupBy('movement_type');

    //     // Sales summary
    //     $salesSummary = [
    //         'total_sales_value' => $movements->get(2, collect())->sum('total_amount'),
    //         'total_items_sold' => $movements->get(2, collect())->count(),
    //         'total_purchases' => $movements->get(1, collect())->sum('total_amount'),
    //         'items_disposed' => $movements->get(3, collect())->count() + $movements->get(6, collect())->count()
    //     ];

    //     // Items expiring today
    //     $expiringToday = InventoryBatch::with(['product:id,name', 'eggType:id,name'])
    //         ->where('expiry_date', $date)
    //         ->where('current_quantity', '>', 0)
    //         ->where('status', 1)
    //         ->get();

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => [
    //             'period' => ['from' => $fromDate, 'to' => $toDate],
    //             'total_loss_value' => $expiredMovements->sum('total_amount'),
    //             'total_expired_items' => $expiredMovements->count(),
    //             'expired_by_item' => $expiredByItem->sortByDesc('loss_value')->take(20),
    //             'expired_by_supplier' => $expiredBySupplier->take(10),
    //             'daily_expiry_trend' => $expiredMovements->groupBy(function($movement) {
    //                 return Carbon::parse($movement->created_at)->format('Y-m-d');
    //             })->map(function($group) {
    //                 return [
    //                     'items_count' => $group->count(),
    //                     'loss_value' => $group->sum('total_amount')
    //                 ];
    //             })
    //         ]
    //     ]);
    // }

    // /**
    //  * Get stock movement analysis
    //  */
    // public function getStockMovementAnalysis(Request $request)
    // {
    //     $days = $request->get('days', 30);
    //     $startDate = Carbon::now()->subDays($days)->toDateString();

    //     $movements = StockMovement::with([
    //         'product:id,name,category_id',
    //         'product.category:id,name',
    //         'eggType:id,name'
    //     ])
    //     ->whereDate('created_at', '>=', $startDate)
    //     ->get();

    //     // Movement velocity (items with high turnover)
    //     $movementVelocity = $movements->where('movement_type', 2) // sales only
    //         ->groupBy(function($movement) {
    //             return $movement->item_type . '-' . $movement->item_id;
    //         })
    //         ->map(function($group) {
    //             $first = $group->first();
    //             return [
    //                 'item_name' => $first->item_type == 1 ? $first->product?->name : $first->eggType?->name,
    //                 'category' => $first->product?->category?->name ?? 'Eggs',
    //                 'total_sold' => $group->sum('quantity'),
    //                 'sales_frequency' => $group->count(),
    //                 'avg_sale_value' => $group->avg('total_amount'),
    //                 'velocity_score' => $group->count() * $group->sum('quantity') // frequency * quantity
    //             ];
    //         })
    //         ->sortByDesc('velocity_score');

    //     // Slow moving items (low sales in the period)
    //     $allItems = Inventory::with(['product:id,name', 'eggType:id,name'])
    //         ->where('total_quantity', '>', 0)
    //         ->get();

    //     $slowMovingItems = $allItems->filter(function($item) use ($movements) {
    //         $itemMovements = $movements->where('item_type', $item->item_type)
    //             ->where('item_id', $item->item_id)
    //             ->where('movement_type', 2); // sales only
            
    //         return $itemMovements->count() <= 2 && $itemMovements->sum('quantity') < 10;
    //     })
    //     ->map(function($item) use ($movements) {
    //         $itemMovements = $movements->where('item_type', $item->item_type)
    //             ->where('item_id', $item->item_id)
    //             ->where('movement_type', 2);
            
    //         return [
    //             'item_name' => $item->item_type == 1 ? $item->product?->name : $item->eggType?->name,
    //             'current_stock' => $item->available_quantity,
    //             'sales_in_period' => $itemMovements->sum('quantity'),
    //             'days_of_stock' => $itemMovements->sum('quantity') > 0 ? 
    //                 ($item->available_quantity / ($itemMovements->sum('quantity') / $days)) : 999
    //         ];
    //     })
    //     ->sortByDesc('days_of_stock');

    //     // Purchase vs Sales analysis
    //     $purchases = $movements->where('movement_type', 1)->sum('total_amount');
    //     $sales = $movements->where('movement_type', 2)->sum('total_amount');
    //     $disposals = $movements->whereIn('movement_type', [3, 6])->sum('total_amount');

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => [
    //             'analysis_period_days' => $days,
    //             'movement_velocity' => $movementVelocity->take(20),
    //             'slow_moving_items' => $slowMovingItems->take(20),
    //             'financial_summary' => [
    //                 'total_purchases' => $purchases,
    //                 'total_sales' => $sales,
    //                 'gross_profit' => $sales - $purchases,
    //                 'total_losses' => $disposals,
    //                 'net_profit' => $sales - $purchases - $disposals,
    //                 'profit_margin' => $sales > 0 ? (($sales - $purchases) / $sales) * 100 : 0
    //             ]
    //         ]
    //     ]);
    // }

    // /**
    //  * Get supplier performance report
    //  */
    // public function getSupplierPerformanceReport(Request $request)
    // {
    //     $months = $request->get('months', 6);
    //     $startDate = Carbon::now()->subMonths($months)->toDateString();

    //     // Get all purchases by supplier
    //     $purchases = StockMovement::with([
    //         'supplier:id,name,phone',
    //         'product:id,name',
    //         'eggType:id,name',
    //         'batch:id,expiry_date'
    //     ])
    //     ->where('movement_type', 1) // purchases
    //     ->whereDate('created_at', '>=', $startDate)
    //     ->get();

    //     // Get expired items by supplier (from batches)
    //     $expiredBySupplier = StockMovement::with(['batch:id,supplier_name,supplier_id'])
    //         ->where('movement_type', 6) // expired
    //         ->whereDate('created_at', '>=', $startDate)
    //         ->get()
    //         ->groupBy('batch.supplier_name');

    //     $supplierPerformance = $purchases->groupBy('supplier_id')
    //         ->map(function($supplierPurchases, $supplierId) use ($expiredBySupplier) {
    //             $supplier = $supplierPurchases->first()->supplier;
    //             $supplierName = $supplier ? $supplier->name : 'Unknown';
                
    //             $expiredItems = $expiredBySupplier->get($supplierName, collect());
                
    //             return [
    //                 'supplier_id' => $supplierId,
    //                 'supplier_name' => $supplierName,
    //                 'supplier_phone' => $supplier?->phone,
    //                 'total_purchases' => $supplierPurchases->count(),
    //                 'total_purchase_value' => $supplierPurchases->sum('total_amount'),
    //                 'avg_purchase_value' => $supplierPurchases->avg('total_amount'),
    //                 'total_quantity_purchased' => $supplierPurchases->sum('quantity'),
    //                 'expired_items_count' => $expiredItems->count(),
    //                 'expired_items_value' => $expiredItems->sum('total_amount'),
    //                 'expiry_rate' => $supplierPurchases->count() > 0 ? 
    //                     ($expiredItems->count() / $supplierPurchases->count()) * 100 : 0,
    //                 'reliability_score' => max(0, 100 - (($expiredItems->count() / max($supplierPurchases->count(), 1)) * 100)),
    //                 'last_purchase_date' => $supplierPurchases->max('created_at')
    //             ];
    //         })
    //         ->sortByDesc('reliability_score');

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => [
    //             'analysis_period_months' => $months,
    //             'supplier_performance' => $supplierPerformance,
    //             'top_suppliers' => $supplierPerformance->take(10),
    //             'suppliers_with_high_expiry' => $supplierPerformance->where('expiry_rate', '>', 20),
    //             'summary' => [
    //                 'total_suppliers' => $supplierPerformance->count(),
    //                 'avg_reliability_score' => $supplierPerformance->avg('reliability_score'),
    //                 'total_purchase_value' => $supplierPerformance->sum('total_purchase_value'),
    //                 'total_expiry_loss' => $supplierPerformance->sum('expired_items_value')
    //             ]
    //         ]
    //     ]);
    // }

    // /**
    //  * Get inventory alerts and notifications
    //  */
    // public function getInventoryAlerts(Request $request)
    // {
    //     $alerts = [];

    //     // Low stock alerts
    //     $lowStockItems = Inventory::with(['product:id,name', 'eggType:id,name'])
    //         ->where('item_type', 1)
    //         ->whereRaw('available_quantity <= (
    //             SELECT min_stock_level 
    //             FROM products 
    //             WHERE products.id = inventory.item_id
    //         )')
    //         ->get()
    //         ->map(function($item) {
    //             return [
    //                 'type' => 'low_stock',
    //                 'priority' => 'medium',
    //                 'item_name' => $item->product?->name ?? $item->eggType?->name,
    //                 'current_stock' => $item->available_quantity,
    //                 'min_stock_level' => $item->product?->min_stock_level ?? 0,
    //                 'message' => "Low stock alert: {$item->product?->name} has only {$item->available_quantity} units left"
    //             ];
    //         });

    //     // Expiring soon alerts (next 3 days)
    //     $expiringSoon = InventoryBatch::with(['product:id,name', 'eggType:id,name'])
    //         ->whereBetween('expiry_date', [
    //             Carbon::now()->toDateString(),
    //             Carbon::now()->addDays(3)->toDateString()
    //         ])
    //         ->where('current_quantity', '>', 0)
    //         ->where('status', 1)
    //         ->get()
    //         ->map(function($batch) {
    //             $daysToExpire = Carbon::parse($batch->expiry_date)->diffInDays(Carbon::now());
    //             return [
    //                 'type' => 'expiring_soon',
    //                 'priority' => $daysToExpire <= 1 ? 'high' : 'medium',
    //                 'item_name' => $batch->product?->name ?? $batch->eggType?->name,
    //                 'batch_number' => $batch->batch_number,
    //                 'expiry_date' => $batch->expiry_date,
    //                 'quantity' => $batch->current_quantity,
    //                 'days_to_expire' => $daysToExpire,
    //                 'message'=> 'Item expires in '.$daysToExpire.' day(s): '.$batch->product?->name ?? $batch->eggType?->name.' (Batch: '.$batch->batch_number.')'
    //             ];
    //         });

    //     // Already expired alerts
    //     $expired = InventoryBatch::with(['product:id,name', 'eggType:id,name'])
    //         ->where('expiry_date', '<', Carbon::now()->toDateString())
    //         ->where('current_quantity', '>', 0)
    //         ->where('status', 1)
    //         ->get()
    //         ->map(function($batch) {
    //             $daysExpired = Carbon::now()->diffInDays($batch->expiry_date);
    //             return [
    //                 'type' => 'expired',
    //                 'priority' => 'high',
    //                 'item_name' => $batch->product?->name ?? $batch->eggType?->name,
    //                 'batch_number' => $batch->batch_number,
    //                 'expiry_date' => $batch->expiry_date,
    //                 'quantity' => $batch->current_quantity,
    //                 'days_expired' => $daysExpired,
    //                 'estimated_loss' => $batch->current_quantity * $batch->cost_price,
    //                 'message'=> 'EXPIRED: '.$batch->product?->name ?? $batch->eggType?->name.' expired '.$daysExpired.' day(s) ago (Batch: '.$batch->batch_number.')'
    //             ];
    //         });

    //     // Combine all alerts
    //     $allAlerts = collect()
    //         ->merge($lowStockItems)
    //         ->merge($expiringSoon)
    //         ->merge($expired)
    //         ->sortBy(function($alert) {
    //             // Sort by priority: high = 1, medium = 2, low = 3
    //             return $alert['priority'] === 'high' ? 1 : ($alert['priority'] === 'medium' ? 2 : 3);
    //         });

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => [
    //             'alerts' => $allAlerts->values(),
    //             'summary' => [
    //                 'total_alerts' => $allAlerts->count(),
    //                 'high_priority' => $allAlerts->where('priority', 'high')->count(),
    //                 'medium_priority' => $allAlerts->where('priority', 'medium')->count(),
    //                 'low_stock_items' => $lowStockItems->count(),
    //                 'expiring_items' => $expiringSoon->count(),
    //                 'expired_items' => $expired->count(),
    //                 'estimated_expiry_loss' => $expired->sum('estimated_loss')
    //             ]
    //         ]
    //     ]);
    // }

    // /**
    //  * Batch update inventory from purchases
    //  */
    // public function addInventoryBatch(Request $request)
    // {
    //     $request->validate([
    //         'item_type' => 'required|integer|in:1,2',
    //         'item_id' => 'required|integer',
    //         'variant_id' => 'nullable|integer',
    //         'quantity' => 'required|integer|min:1',
    //         'unit_id' => 'required|integer',
    //         'cost_price' => 'required|numeric|min:0',
    //         'selling_price' => 'required|numeric|min:0',
    //         'expiry_date' => 'nullable|date|after:today',
    //         'supplier_id' => 'nullable|integer',
    //         'supplier_name' => 'required|string',
    //         'purchase_date' => 'required|date',
    //         'notes' => 'nullable|string'
    //     ]);

    //     try {
    //         \DB::beginTransaction();

    //         // Generate batch number
    //         $batchNumber = 'B' . Carbon::now()->format('YmdHis') . rand(100, 999);

    //         // Create inventory batch
    //         $batch = InventoryBatch::create([
    //             'item_type' => $request->item_type,
    //             'item_id' => $request->item_id,
    //             'variant_id' => $request->variant_id,
    //             'batch_number' => $batchNumber,
    //             'supplier_id' => $request->supplier_id,
    //             'supplier_name' => $request->supplier_name,
    //             'purchase_date' => $request->purchase_date,
    //             'expiry_date' => $request->expiry_date,
    //             'initial_quantity' => $request->quantity,
    //             'current_quantity' => $request->quantity,
    //             'unit_id' => $request->unit_id,
    //             'cost_price' => $request->cost_price,
    //             'selling_price' => $request->selling_price,
    //             'status' => 1,
    //             'notes' => $request->notes,
    //             'created_by' => auth()->id()
    //         ]);

    //         // Create stock movement
    //         StockMovement::create([
    //             'item_type' => $request->item_type,
    //             'item_id' => $request->item_id,
    //             'variant_id' => $request->variant_id,
    //             'batch_id' => $batch->id,
    //             'movement_type' => 1, // purchase
    //             'quantity' => $request->quantity,
    //             'unit_id' => $request->unit_id,
    //             'unit_price' => $request->cost_price,
    //             'total_amount' => $request->quantity * $request->cost_price,
    //             'supplier_id' => $request->supplier_id,
    //             'supplier_name' => $request->supplier_name,
    //             'reference_type' => 'purchase',
    //             'notes' => $request->notes,
    //             'created_by' => auth()->id()
    //         ]);

    //         // Update main inventory
    //         $this->updateInventorySummary($request->item_type, $request->item_id, $request->variant_id);

    //         \DB::commit();

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Inventory batch added successfully',
    //             'data' => $batch->load(['product', 'eggType', 'unit'])
    //         ]);

    //     } catch (\Exception $e) {
    //         \DB::rollback();
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Failed to add inventory batch: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // /**
    //  * Get inventory forecast and recommendations
    //  */
    // public function getInventoryForecast(Request $request)
    // {
    //     $days = $request->get('forecast_days', 30);
        
    //     // Get sales data for last 90 days to calculate average
    //     $salesData = StockMovement::where('movement_type', 2)
    //         ->where('created_at', '>=', Carbon::now()->subDays(90))
    //         ->get()
    //         ->groupBy(function($movement) {
    //             return $movement->item_type . '-' . $movement->item_id;
    //         });

    //     $forecast = Inventory::with(['product:id,name,min_stock_level', 'eggType:id,name'])
    //         ->where('available_quantity', '>', 0)
    //         ->get()
    //         ->map(function($item) use ($salesData, $days) {
    //             $itemKey = $item->item_type . '-' . $item->item_id;
    //             $itemSales = $salesData->get($itemKey, collect());
                
    //             $avgDailySales = $itemSales->count() > 0 ? 
    //                 $itemSales->sum('quantity') / 90 : 0;
                
    //             $forecastDemand = $avgDailySales * $days;
    //             $stockOutDays = $avgDailySales > 0 ? 
    //                 $item->available_quantity / $avgDailySales : 999;
                
    //             return [
    //                 'item_name' => $item->product?->name ?? $item->eggType?->name,
    //                 'current_stock' => $item->available_quantity,
    //                 'avg_daily_sales' => round($avgDailySales, 2),
    //                 'forecast_demand' => round($forecastDemand),
    //                 'stock_out_in_days' => round($stockOutDays),
    //                 'recommended_reorder' => max(0, $forecastDemand - $item->available_quantity),
    //                 'min_stock_level' => $item->product?->min_stock_level ?? 0,
    //                 'stock_status' => $stockOutDays < $days ? 'reorder_needed' : 'sufficient'
    //             ];
    //         })
    //         ->sortBy('stock_out_in_days');

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => [
    //             'forecast_period_days' => $days,
    //             'inventory_forecast' => $forecast,
    //             'items_needing_reorder' => $forecast->where('stock_status', 'reorder_needed'),
    //             'total_reorder_value' => $forecast->sum('recommended_reorder')
    //         ]
    //     ]);
    // }

    // /**
    //  * Get weekly inventory report
    //  */
    // public function getWeeklyInventoryReport(Request $request)
    // {
    //     $startDate = $request->get('start_date', Carbon::now()->startOfWeek()->toDateString());
    //     $endDate = $request->get('end_date', Carbon::now()->endOfWeek()->toDateString());

    //     // Weekly movements
    //     $movements = StockMovement::with(['product:id,name', 'eggType:id,name'])
    //         ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
    //         ->get();

    //     // Group by day
    //     $dailyMovements = $movements->groupBy(function($movement) {
    //         return Carbon::parse($movement->created_at)->format('Y-m-d');
    //     });

    //     // Weekly summary
    //     $weeklySummary = [
    //         'total_sales' => $movements->where('movement_type', 2)->sum('total_amount'),
    //         'total_purchases' => $movements->where('movement_type', 1)->sum('total_amount'),
    //         'items_expired' => $movements->where('movement_type', 6)->count(),
    //         'items_disposed' => $movements->where('movement_type', 3)->count(),
    //         'net_profit' => $movements->where('movement_type', 2)->sum('total_amount') - 
    //                        $movements->where('movement_type', 1)->sum('total_amount')
    //     ];

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => [
    //             'period' => ['start' => $startDate, 'end' => $endDate],
    //             'daily_movements' => $dailyMovements,
    //             'weekly_summary' => $weeklySummary
    //         ]
    //     ]);
    // }

    // /**
    //  * Get monthly inventory report
    //  */
    // public function getMonthlyInventoryReport(Request $request)
    // {
    //     $month = $request->get('month', Carbon::now()->month);
    //     $year = $request->get('year', Carbon::now()->year);
        
    //     $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
    //     $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

    //     // Monthly movements
    //     $movements = StockMovement::with(['product:id,name', 'eggType:id,name'])
    //         ->whereBetween('created_at', [$startDate, $endDate])
    //         ->get();

    //     // Top selling items
    //     $topSellingItems = $movements->where('movement_type', 2)
    //         ->groupBy(function($movement) {
    //             return $movement->item_type . '-' . $movement->item_id;
    //         })
    //         ->map(function($group) {
    //             $first = $group->first();
    //             return [
    //                 'item_name' => $first->item_type == 1 ? $first->product?->name : $first->eggType?->name,
    //                 'total_quantity' => $group->sum('quantity'),
    //                 'total_revenue' => $group->sum('total_amount'),
    //                 'movement_count' => $group->count()
    //             ];
    //         })
    //         ->sortByDesc('total_revenue')
    //         ->take(10);

    //     // Expiry analysis
    //     $expiryLoss = $movements->where('movement_type', 6)->sum('total_amount');
    //     $disposalLoss = $movements->where('movement_type', 3)->sum('total_amount');

    //     // Category wise sales
    //     $categorySales = $movements->where('movement_type', 2)
    //         ->where('item_type', 1)
    //         ->groupBy('product.category.name')
    //         ->map(function($group) {
    //             return [
    //                 'sales_count' => $group->count(),
    //                 'total_revenue' => $group->sum('total_amount'),
    //                 'total_quantity' => $group->sum('quantity')
    //             ];
    //         });

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => [
    //             'period' => ['month' => $month, 'year' => $year],
    //             'monthly_summary' => [
    //                 'total_sales' => $movements->where('movement_type', 2)->sum('total_amount'),
    //                 'total_purchases' => $movements->where('movement_type', 1)->sum('total_amount'),
    //                 'expiry_loss' => $expiryLoss,
    //                 'disposal_loss' => $disposalLoss,
    //                 'total_loss' => $expiryLoss + $disposalLoss
    //             ],
    //             'top_selling_items' => $topSellingItems,
    //             'category_wise_sales' => $categorySales
    //         ]
    //     ]);
    // }

    // /**
    //  * Get expiry loss report
    //  */
    // public function getExpiryLossReport(Request $request)
    // {
    //     $fromDate = $request->get('from_date', Carbon::now()->subDays(30)->toDateString());
    //     $toDate = $request->get('to_date', Carbon::now()->toDateString());

    //     // Expired items movements
    //     $expiredMovements = StockMovement::with([
    //         'product:id,name,name_bn,category_id',
    //         'product.category:id,name',
    //         'eggType:id,name,name_bn',
    //         'batch:id,batch_number,supplier_name,expiry_date'
    //     ])
    //     ->where('movement_type', 6) // expired
    //     ->whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
    //     ->get();

    //     // Group by item
    //     $expiredByItem = $expiredMovements->groupBy(function($movement) {
    //         return $movement->item_type . '-' . $movement->item_id;
    //     })
    //     ->map(function($group) {
    //         $first = $group->first();
    //         return [
    //             'item_name' => $first->item_type == 1 ? $first->product?->name : $first->eggType?->name,
    //             'category' => $first->product?->category?->name ?? 'Eggs',
    //             'expired_quantity' => $group->sum('quantity'),
    //             'loss_value' => $group->sum('total_amount'),
    //             'expired_count' => $group->count(),
    //             'avg_days_expired' => $group->avg(function($movement) {
    //                 return $movement->batch ? 
    //                     Carbon::parse($movement->created_at)->diffInDays($movement->batch->expiry_date) : 0;
    //             })
    //         ];
    //     });

    //     // Supplier wise expiry analysis
    //     $expiredBySupplier = $expiredMovements->groupBy('batch.supplier_name')
    //         ->map(function($group, $supplier) {
    //             return [
    //                 'supplier_name' => $supplier ?: 'Unknown',
    //                 'expired_items' => $group->count(),
    //                 'loss_value' => $group->sum('total_amount'),
    //                 'expired_quantity' => $group->sum('quantity')
    //             ];
    //         })
    //         ->sortByDesc('loss_value');

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => [
    //             'from_date' => $fromDate,
    //             'to_date' => $toDate,
    //             'expired_by_item' => $expiredByItem,
    //             'expired_by_supplier' => $expiredBySupplier
    //         ]
    //     ]);
    // }
}
