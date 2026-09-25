<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContractSignatureController;

// 1. صفحة إنشاء العقد الرئيسية (لوحة الـ HR)
Route::get('/', function () {
    return view('welcome');
});

// 2. قائمة كل العقود وجدول البيانات
Route::get('/contracts', [ContractSignatureController::class, 'index'])->name('contracts.index');

// 3. بوابة عرض صفحة التوقيع للموظف
Route::get('/sign-contract/{id}', [ContractSignatureController::class, 'show'])->name('contract.sign');

// 4. استقبال ومعالجة التوقيع الرقمي
Route::post('/sign-contract/{id}', [ContractSignatureController::class, 'sign'])->name('contract.store_signature');
// رابط تحميل السيرة الذاتية للمتقدم
Route::get('/download-cv/{id}', [ContractSignatureController::class, 'downloadCv'])->name('candidate.download_cv');
