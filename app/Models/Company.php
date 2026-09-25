<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    // السماح بإدخال هذه البيانات جماعياً
    protected $fillable = ['name', 'tax_number'];

    // علاقة الشركة بالمستخدمين (المدرين)
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // علاقة الشركة بالمتقدمين للوظائف
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }
}


