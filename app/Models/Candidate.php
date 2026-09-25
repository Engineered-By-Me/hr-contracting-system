<?php
namespace App\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
    
    class Candidate extends Model
    {
        protected $fillable = ['company_id', 'first_name', 'last_name', 'email', 'phone', 'cv_path', 'status'];
    
        // المتقدم ينتمي إلى شركة
        public function company(): BelongsTo
        {
            return $this->belongsTo(Company::class);
        }
    
        // المتقدم لديه عقود
        public function contracts(): HasMany
        {
            return $this->hasMany(Contract::class);
        }
    }
    

