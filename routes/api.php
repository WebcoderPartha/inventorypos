<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\VatController;
use App\Http\Controllers\Api\OrderController;

Route::group([
//    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);

    Route::apiResource('employee', EmployeeController::class);
    Route::apiResource('supplier', SupplierController::class);
//    Route::apiResource('category', CategoryController::class);
    Route::get('/category', [CategoryController::class, 'index']);
    Route::post('/category', [CategoryController::class, 'store']);
    Route::get('/category/{id}', [CategoryController::class, 'show']);
    Route::put('/category/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/{id}', [CategoryController::class, 'destroy']);
    Route::get('/ctsearch', [CategoryController::class, 'searchCategory']);
    Route::get('/getcategory', [CategoryController::class, 'getAllCategory']);

    // Supplier
    Route::get('/getsupplier', [SupplierController::class, 'getAllSupplier']);

    // Product APIs
    Route::apiResource('/product', ProductController::class);
    // Stock update
    Route::put('/stockupdate/{id}', [ProductController::class, 'updateStock']);

    // Expense APIs
    Route::apiResource('/expense', ExpenseController::class);

    // Customer APIs
    Route::apiResource('/customer', CustomerController::class);

    // Salary APIs
    Route::post('/salary/pay/{id}', [SalaryController::class, 'storePaySalary']);
    Route::get('/getsalaries', [SalaryController::class, 'getAllSalary']);
    Route::get('/paid-month/{month}', [SalaryController::class, 'viewPaidByMonth']);
    Route::get('/salary/show/{id}', [SalaryController::class,'Show']);
    Route::put('/paid-salary/{id}', [SalaryController::class, 'updatePaidSalary']);

    // POS APIs
    Route::get('/posgetproducts', [PosController::class, 'getAllProduct']);
    Route::get('/getcateries', [PosController::class, 'getAllCategory']);
    Route::get('/getptctby/{id}', [PosController::class, 'getProductCategoryById']);

    // Cart APIs
    Route::post('/addcart/{id}', [CartController::class, 'addToCart']);
    Route::get('/getaddcarts', [CartController::class, 'getAddToCart']);
    Route::delete('/remove-cart/{id}', [CartController::class, 'removeCart']);
    Route::get('/incrementcart/{id}', [CartController::class, 'incrementCart']);
    Route::get('/decrementcart/{id}', [CartController::class, 'decrementCart']);
    Route::get('/cartdetails', [CartController::class, 'cartDetails']);

    // Vat APIs
    Route::get('/vat', [VatController::class, 'getVat']);
    Route::post('/vat-update', [VatController::class, 'updateVat']);

    // Order APIs
    Route::post('/order-success', [OrderController::class, 'orderSuccess']);
    Route::get('/orders', [OrderController::class, 'getTodayOrder']);
    Route::get('/order-details/{id}', [OrderController::class, 'getOrderDetails']);
    Route::get('/singleorder/{id}', [OrderController::class, 'getSingleOrder']);
    Route::get('/getallorder', [OrderController::class, 'getAllOrder']);
    Route::post('/search-order', [OrderController::class, 'searchOrder']);

    // Reports Routes
    Route::get('/todady-sale', [OrderController::class, 'todaySale']);
    Route::get('/todady-income', [OrderController::class, 'todayIncome']);
    Route::get('/todady-due', [OrderController::class, 'todayDue']);
    Route::get('/todady-expense', [OrderController::class, 'todayExpense']);
    Route::get('/getstockoutproducts', [OrderController::class, 'getStockOutProduct']);

});



