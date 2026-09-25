<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Company;
use App\Models\Candidate;
use App\Models\Contract;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContractReadyMail;






class ContractManager extends Component
{use WithFileUploads; // تفعيل ميزة رفع الملفات الذكية

    public $cv; // متغير استقبال ملف السيرة الذاتية
    
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $title;
    public $salary;
    public $start_date;

    protected $rules = [
        'first_name' => 'required|string|min:2|max:50',
        'last_name' => 'required|string|min:2|max:50',
        'email' => 'required|email',
        'title' => 'required|string|min:3|max:100',
        'salary' => 'required|numeric|min:1000',
        'start_date' => 'required|date|after_or_equal:today',
        'cv' => 'required|file|mimes:pdf|max:2048',

    ];

    protected $messages = [
        'first_name.required' => 'الاسم الأول مطلوب.',
        'last_name.required' => 'الاسم الأخير مطلوب.',
        'email.required' => 'البريد الإلكتروني مطلوب.',
        'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
        'title.required' => 'المسمى الوظيفي مطلوب لعقد العمل.',
        'salary.required' => 'الراتب السنوي مطلوب.',
        'salary.numeric' => 'يجب أن يكون الراتب رقماً صحيحاً.',
        'start_date.required' => 'تاريخ بدء العمل مطلوب.',
        'start_date.after_or_equal' => 'تاريخ بدء العمل لا يمكن أن يكون في الماضي.',
    ];
    public function createContract()
    {
        $this->validate();
    
        DB::transaction(function () {
            $company = Company::firstOrCreate(
                ['name' => 'BMW Group Germany'],
                ['tax_number' => 'DE123456789']
            );
            // ---- [ شغل محترفين: رفع وحفظ السيرة الذاتية ] ----
            $cvFolder = 'cvs';
            $cvPath = $this->cv->store($cvFolder, 'public');
            // --------------------------------------------------
    
            $candidate = Candidate::create([
                'company_id' => $company->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'cv_path' => $cvPath, // صب مسار الملف الحقيقي هنا بنجاح!
                'status' => 'accepted',
            ]);
    
            $contract = Contract::create([
                'candidate_id' => $candidate->id,
                'title' => $this->title,
                'salary' => $this->salary,
                'start_date' => $this->start_date,
                'status' => 'sent', // تحولت الحالة إلى مرسل بانتظار التوقيع
            ]);
    
            // ---- [ شُغل المحترفين: توليد ملف الـ PDF آلياً هنا ] ----
            $data = [
                'company_name' => $company->name,
                'tax_number'   => $company->tax_number,
                'candidate_name' => $candidate->first_name . ' ' . $candidate->last_name,
                'job_title'    => $contract->title,
                'salary'       => $contract->salary,
                'start_date'   => $contract->start_date,
                'status'       => $contract->status,
                'signed_at'    => ''
            ];
    
            // تحميل التصميم وصب البيانات داخله
            $pdf = Pdf::loadView('contract_pdf', $data);
    
            // إنشاء اسم فريد ومحمي للملف
            $fileName = 'contracts/contract_' . $contract->id . '_' . time() . '.pdf';
            
            // حفظ الملف في القرص المحلي للسيرفر بأمان (storage/app/public/)
            Storage::disk('public')->put($fileName, $pdf->output());
    

                    // ---- [ شغل الشركات: إرسال الإيميل التلقائي للموظف بالرابط ] ----
        $secureUrl = route('contract.sign', ['id' => $contract->id]);
        $fullName = $candidate->first_name . ' ' . $candidate->last_name;

        // إرسال الإيميل إلى بريد الموظف الحقيقي المخزن في الاستمارة
        Mail::to($candidate->email)->send(new ContractReadyMail($fullName, $secureUrl));
        // -------------------------------------------------------------

        $this->reset();
        return redirect()->route('contracts.index')->with('message', 'Vertrag erstellt und E-Mail gesendet! تم إنشاء العقد وإرسال رابط التوقيع للموظف عبر الإيميل تلقائياً 🚀');

            // تحديث قاعدة البيانات بمسار الملف الفعلي
            $contract->update(['pdf_path' => $fileName]);
            // --------------------------------------------------------
    
            $this->reset();
    
           
                // توليد رابط آمن ومشفر وصالح للاستخدام ولا يمكن تزويره أو تخمينه
                $secureUrl = URL::signedRoute('contract.sign', ['id' => $contract->id]);

                $this->reset();
        
                        // شغل محترفين: التوجيه التلقائي لصفحة قائمة العقود بعد الحفظ فوراً
        return redirect()->route('contracts.index')->with('message', 'Vertrag erfolgreich erstellt! تم إنشاء العقد بنجاح وتحويلك لقائمة العقود 🚀');
    });
}

       
    
    
    
    public function render()
    {
        return view('livewire.contract-manager');
    }
}
