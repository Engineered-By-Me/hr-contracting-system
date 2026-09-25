<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. إنشاء جدول الشركات أولاً
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tax_number')->nullable();
            $table->timestamps();
        });
    
        // 2. بعد إنشاء الشركات، نذهب لجدول الـ users ونضيف حقل الربط بأمان
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')->after('id')->nullable()->constrained()->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // عند التراجع، نحذف العلاقة أولاً ثم نحذف جدول الشركات
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
        
        Schema::dropIfExists('companies');
    }
};
