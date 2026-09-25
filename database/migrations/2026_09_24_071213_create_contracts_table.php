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
            Schema::create('contracts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('candidate_id')->constrained()->onDelete('cascade');
                $table->string('title'); // مسمى الوظيفة بالعقد
                $table->decimal('salary', 10, 2); // الراتب باليورو
                $table->date('start_date'); // تاريخ المباشرة
                $table->string('pdf_path')->nullable(); // مسار العقد النهائي
                $table->enum('status', ['draft', 'sent', 'signed', 'expired'])->default('draft');
                $table->timestamp('signed_at')->nullable(); // وقت التوقيع الدقيق
                $table->string('signature_token')->nullable(); // الرمز التشفيري الفريد للحماية من التزوير
                $table->timestamps();
            });
        }
        
 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
