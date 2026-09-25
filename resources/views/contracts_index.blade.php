<!DOCTYPE html>
<html lang="de" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>ZeitKontrakt - Liste der Vertraege</title>
    <style>
        body { background-color: #f1f5f9; font-family: system-ui, sans-serif; padding: 40px; }
        .container { max-width: 1000px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 20px; }
        h1 { font-size: 22px; color: #1e293b; margin: 0; }
        .btn-add { background: #2563eb; color: #fff; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; text-align: left; }
        th { background: #f8fafc; padding: 12px; font-size: 14px; color: #64748b; border-bottom: 1px solid #e2e8f0; }
        td { padding: 14px 12px; font-size: 14px; color: #334155; border-bottom: 1px solid #f1f5f9; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 700; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-success { background: #dcfce7; color: #166534; }
        .btn-action { background: #10b981; color: #fff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; }
        .btn-action:hover { background: #059669; }
        .flash-msg { padding: 12px; background: #f0fdf4; border-left: 4px solid #22c55e; color: #166534; border-radius: 4px; margin-bottom: 20px; font-weight: 500; font-family: sans-serif; text-align: right; direction: rtl; }
    </style>
</head>
<body>

    <div class="container">
        <!-- رأس الصفحة -->
        <div class="header">
            <h1>Vertragsverwaltung (إدارة العقود الرقمية)</h1>
            <!-- زر تلقائي يعيدك لصفحة إنشاء عقد جديد -->
            <a href="/" class="btn-add">عقد جديد +</a>
        </div>

        <!-- رسالة النجاح القادمة من الـ Redirect -->
        @if(session()->has('message'))
            <div class="flash-msg">{{ session('message') }}</div>
        @endif

        <!-- جدول عرض البيانات التلقائي -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mitarbeiter (الموظف)</th>
                    <th>Position</th>
                    <th>Gehalt</th>
                    <th>Status</th>
                    <th>Aktion (الإجراء)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contracts as $contract)
                <tr>
                    <td>{{ $contract->id }}</td>
                    <td style="font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
    <span>{{ $contract->candidate->first_name }} {{ $contract->candidate->last_name }}</span>
    
    <!-- زر تحميل السيرة الذاتية الديناميكي والمربوط بالرابط الصافي -->
    <a href="{{ route('candidate.download_cv', $contract->id) }}" title="Download CV" style="background-color: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 4px; text-decoration: none; font-size: 11px; border: 1px solid #cbd5e1; font-weight: 500; margin-left: 8px;">
        تنزيل الـ CV 📄
    </a>
</td>

                    <td>{{ $contract->title }}</td>
                    <td>€{{ number_format($contract->salary, 2) }}</td>
                    <td>
                        @if($contract->status == 'signed')
                            <span class="badge badge-success">Signiert</span>
                        @else
                            <span class="badge badge-warning">Ausstehend</span>
                        @endif
                    </td>
                    <td>
                        <!-- السحر هنا: زر ديناميكي ينقلك لصفحة توقيع هذا العقد بالذات دون كتابة روابط -->
                        <a href="{{ route('contract.sign', $contract->id) }}" class="btn-action">
                            {{ $contract->status == 'signed' ? 'عرض العقد 📄' : 'توقيع الآن ✍️' }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
