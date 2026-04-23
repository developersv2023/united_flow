<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Reportes Excel
    Route::get('/agencies/export/excel.csv', [AgencyController::class, 'exportExcel'])->name('agencies.excel');
    Route::get('/clients/export/excel.csv', [ClientController::class, 'exportExcel'])->name('clients.excel');
    Route::get('/pending_invoices/export/excel.csv', [\App\Http\Controllers\PendingInvoiceController::class, 'exportExcel'])->name('pending_invoices.excel');
    Route::get('/sales/export/excel.csv', [\App\Http\Controllers\SaleController::class, 'exportExcel'])->name('sales.excel');

    Route::get('/agency_transactions/export/excel.csv', [\App\Http\Controllers\AgencyTransactionController::class, 'exportExcel'])->name('agency_transactions.excel');

    // Reportes en General
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

    // CRUD Catálogos
    Route::resource('agency_transactions', \App\Http\Controllers\AgencyTransactionController::class);
    Route::resource('agencies', AgencyController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('pending_invoices', \App\Http\Controllers\PendingInvoiceController::class);
    Route::resource('sales', \App\Http\Controllers\SaleController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
