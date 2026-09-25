<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    protected $fillable = [
        'candidate_id', 
        'title', 
        'salary', 
        'start_date', 
        'pdf_path', // تأكد من إضافة هذا السطر هنا بأمان
        'status', 
        'signed_at', 
        'signature_token'
    ];
    

    // العقد ينتمي إلى موظف/متقدم محدد
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }
}

