<?php

use App\Http\Controllers\API\V1\AuthenticationController;
use App\Http\Controllers\API\V1\InventoryController;
use App\Http\Controllers\API\V1\TodoManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\UserManagementController as UserController;

Route::controller(AuthenticationController::class)->group(function () {
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/refresh', 'refresh')->name('refresh');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'users')->name('users');
    Route::get('/user/{id}', 'user')->name('user');
    Route::get('/admins', 'admins')->name('admins');
});


Route::group(['prefix' => '/me', 'as' => 'me.'], function () {
    Route::controller(TodoManagementController::class)->prefix('/todos')->name('todos.')->group(function () {
        Route::get('/', 'todos')->name('todos');
        Route::get('/{id}', 'todo')->name('todo');
        Route::get('/due', 'dueTodos')->name('dueTodos');
        Route::post('/', 'createTodo')->name('createTodo');
        Route::put('/{id}', 'updateTodo')->name('updateTodo');
        Route::delete('/{id}', 'deleteTodo')->name('deleteTodo');
        Route::delete('/', 'bulkDeleteTodo')->name('bulkDeleteTodo');
        Route::post('/{id}/complete', 'completeTodo')->name('completeTodo');
        Route::post('/{id}/incomplete', 'incompleteTodo')->name('incompleteTodo');
        Route::post('/{id}/due', 'dueTodo')->name('dueTodo');
    });
});

Route::prefix('inventory')->middleware(['auth:sanctum'])->group(function () {
    
    // ============================================
    // General Inventory Management
    // ============================================
    
    // Get all inventory items
    Route::get('/', [InventoryController::class, 'getAllInventory']);
    
    // Get specific item inventory detail
    Route::get('/item/{itemType}/{itemId}/{variantId?}', [InventoryController::class, 'getItemInventoryDetail']);
    
    // Get inventory summary for dashboard
    Route::get('/summary', [InventoryController::class, 'getInventorySummary']);
    
    // Get low stock items
    Route::get('/low-stock', [InventoryController::class, 'getLowStockItems']);
    
    // ============================================
    // Expiry Management
    // ============================================
    
    // Get expired items
    Route::get('/expired', [InventoryController::class, 'getExpiredItems']);
    
    // Get items expiring soon
    Route::get('/expiring-soon', [InventoryController::class, 'getExpiringSoonItems']);
    
    // Process expired items (move to disposed)
    Route::post('/process-expired', [InventoryController::class, 'processExpiredItems']);
    
    // ============================================
    // Stock Movements Tracking
    // ============================================
    
    // Get all stock movements
    Route::get('/movements', [InventoryController::class, 'getStockMovements']);
    
    // Get sold items tracking
    Route::get('/sold-items', [InventoryController::class, 'getSoldItems']);
    
    // Get disposed items tracking
    Route::get('/disposed-items', [InventoryController::class, 'getDisposedItems']);
    
    // Get purchased items tracking
    Route::get('/purchased-items', [InventoryController::class, 'getPurchasedItems']);
    
    // ============================================
    // Sales & FIFO Management
    // ============================================
    
    // Get available items for sale (FIFO)
    Route::get('/available/{itemType}/{itemId}/{variantId?}', [InventoryController::class, 'getAvailableItemsForSale']);
    
    // Process sale with FIFO logic
    Route::post('/process-sale', [InventoryController::class, 'processSale']);
    
    // ============================================
    // Tray Tracking (Egg Business Specific)
    // ============================================
    
    // Get tray tracking
    Route::get('/tray-tracking', [InventoryController::class, 'getTrayTracking']);
    
});
