<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ContractSignatureController extends Controller
{


        /**
     * جلب وعرض قائمة كل العقود في جدول البيانات التلقائي
     */
    public function index()
    {
        // جلب كل العقود مع بيانات المتقدمين المرتبطين بها بضربة واحدة من قاعدة البيانات
        $contracts = \App\Models\Contract::with('candidate')->orderBy('id', 'desc')->get();
        
        return view('contracts_index', compact('contracts'));
    }

    /**
     * عرض صفحة بوابة التوقيع للموظف
     */
    public function show($id)
    {
        $contract = Contract::findOrFail($id);
        return view('sign_portal', compact('contract'));
    }

    /**
     * استقبال التوقيع، تشفيره، وتحديث ملف الـ PDF
     */    /**
     * استقبال التوقيع، تشفيره، وتحديث ملف الـ PDF بأمان
     */
    public function sign(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        if (!$request->signature_image) {
            return back()->with('error', 'يرجى رسم التوقيع أولاً.');
        }

        // هندسة الأمان الألمانية: قفل العقد برمز تشفير فريد (Hash)
        $signatureToken = hash('sha256', $contract->id . time() . $contract->salary);

        // إذا كان مسار الـ PDF فارغاً لأي سبب محلي، نولد له مساراً فورياً حمايةً للسيرفر
        $pdfPath = $contract->pdf_path ?? 'contracts/contract_' . $contract->id . '_' . time() . '.pdf';

        $contract->update([
            'status' => 'signed',
            'signed_at' => now(),
            'signature_token' => $signatureToken,
            'pdf_path' => $pdfPath // نؤكد حفظ المسار في قاعدة البيانات هنا أيضاً
        ]);

        $candidate = $contract->candidate;
        $company = $candidate->company;

        $data = [
            'company_name' => $company->name,
            'tax_number'   => $company->tax_number,
            'candidate_name' => $candidate->first_name . ' ' . $candidate->last_name,
            'job_title'    => $contract->title,
            'salary'       => $contract->salary,
            'start_date'   => $contract->start_date,
            'status'       => $contract->status,
            'signed_at'    => $contract->signed_at->format('d.m.Y H:i')
        ];

        // إعادة توليد ملف الـ PDF ليوثق التوقيع والتاريخ في المستند
        $pdf = Pdf::loadView('contract_pdf', $data);
        
        // شغل محترفين: نستخدم المتغير المحلي $pdfPath المضمون النصي بدلاً من $contract->pdf_path
        Storage::disk('public')->put($pdfPath, $pdf->output());

        return back();
    }


        /**
     * تحميل السيرة الذاتية للمتقدم بأمان من السيرفر
     */
    public function downloadCv($id)
    {
        // جلب العقد ومعه بيانات المتقدم
        $contract = Contract::findOrFail($id);
        $candidate = $contract->candidate;

        // التحقق من وجود ملف السيرة الذاتية مخزناً بالفعل
        if (!$candidate->cv_path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($candidate->cv_path)) {
            return back()->with('error', 'Datei nicht gefunden! لم يتم العثور على ملف السيرة الذاتية في السيرفر.');
        }

        // إنشاء اسم تحميل أنيق رسمي باسم الموظف (مثال: CV_Ahmad_Alali.pdf)
        $downloadName = 'CV_' . $candidate->first_name . '_' . $candidate->last_name . '.pdf';

        // شغل محترفين: إرسال الملف كأمر تحميل مباشر للمتصفح
        return \Illuminate\Support\Facades\Storage::disk('public')->download($candidate->cv_path, $downloadName);
    }

}
