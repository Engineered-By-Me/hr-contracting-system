<!DOCTYPE html>
<html lang="de" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZeitKontrakt - بوابة التوقيع الرقمي</title>
    <style>
        /* تنسيق محلي صارم لا يحتاج للإنترنت مطلقاً */
        body { background-color: #f1f5f9; font-family: system-ui, -apple-system, sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: 40px auto; background-color: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; }
        .header { border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 24px; text-align: left; }
        .header h1 { font-size: 24px; font-weight: 700; color: #1e293b; margin: 0; }
        .header p { color: #64748b; font-size: 14px; margin-top: 6px; text-align: right; direction: rtl; }
        .info-box { background-color: #eff6ff; border: 1px solid #bfdbfe; padding: 20px; border-radius: 8px; margin-bottom: 24px; }
        .info-box h2 { font-size: 16px; font-weight: 700; color: #1e40af; margin-top: 0; margin-bottom: 12px; text-align: right; direction: rtl; }
        .grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; font-size: 14px; color: #334155; text-align: left; }
        .font-bold { font-weight: 600; }
        .badge { px: 8px; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 700; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .badge-success { background-color: #dcfce7; color: #166534; }
        label { display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 8px; text-align: right; direction: rtl; }
        #signature-pad { border: 2px dashed #cbd5e1; background-color: #fafafa; border-radius: 8px; cursor: crosshair; touch-action: none; width: 100%; display: block; }
        .flex-row { display: flex; justify-content: space-between; align-items: center; margin-top: 16px; }
        .btn-clear { background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 500; font-size: 14px; transition: background 0.2s; }
        .btn-clear:hover { background-color: #e2e8f0; }
        .btn-submit { background-color: #16a34a; color: #ffffff; border: none; padding: 10px 24px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 14px; box-shadow: 0 4px 6px -1px rgba(22, 163, 74, 0.2); transition: background 0.2s; }
        .btn-submit:hover { background-color: #15803d; }
        .success-box { p: 24px; padding: 24px; background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; text-align: center; }
        .success-box p { color: #166534; font-weight: 600; font-size: 18px; margin: 0; }
        .success-box span { color: #64748b; font-size: 14px; display: block; margin-top: 6px; }
    </style>
</head>
<body>

    <div class="container">
        <!-- الرأس -->
        <div class="header">
            <h1>Arbeitsvertrag Unterschreiben</h1>
            <p>يرجى مراجعة تفاصيل عقدك مع شركة BMW في الأسفل وتوقيعه رقمياً لإتمام التعاقد.</p>
        </div>

        <!-- تفاصيل العقد السريعة -->
        <div class="info-box">
            <h2>معلومات العقد الأساسية:</h2>
            <div class="grid">
                <div><span class="font-bold">Position:</span> {{ $contract->title }}</div>
                <div><span class="font-bold">Gehalt (الراتب):</span> €{{ number_format($contract->salary, 2) }} / Jahr</div>
                <div><span class="font-bold">Beginn:</span> {{ $contract->start_date }}</div>
                <div><span class="font-bold">Status:</span> 
                    @if($contract->status == 'signed')
                        <span class="badge badge-success">Signiert (تم التوقيع)</span>
                    @else
                        <span class="badge badge-warning">Ausstehend (معلق)</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- التحقق من حالة العقد للعرض والتوقيع -->
        @if($contract->status !== 'signed')
            <div>
                <label>ارسم توقيعك داخل المربع أدناه (بالإصبع أو الماوس):</label>
                
                <!-- لوحة الرسم الذكية -->
                <canvas id="signature-pad" width="740" height="200"></canvas>
                
                <div class="flex-row">
                    <button type="button" id="clear-btn" class="btn-clear">
                        مسح وإعادة الرسم ↩️
                    </button>
                    
                    <form action="{{ route('contract.store_signature', $contract->id) }}" method="POST" id="sign-form">
                        @csrf
                        <input type="hidden" name="signature_image" id="signature-input">
                        <button type="submit" class="btn-submit">
                            اعتماد وتوقيع العقد رسمياً ✍️
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="success-box">
                <p>Vielen Dank! Der Vertrag wurde erfolgreich signiert. 🎉</p>
                <span>تم توقيع العقد بنجاح وحفظ النسخة القانونية المشفرة بداخل خادم السيرفر التابع للشركة الألمانية.</span>
            </div>
        @endif
    </div>

    <!-- كود جافاسكريبت المطور للرسم السلس -->
    <script>
        const canvas = document.getElementById('signature-pad');
        const ctx = canvas.getContext('2d');
        let isDrawing = false;

        ctx.strokeStyle = '#1e3a8a'; 
        ctx.lineWidth = 3;
        ctx.lineCap = 'round';

        function startDrawing(e) {
            isDrawing = true;
            draw(e);
        }

        function stopDrawing() {
            isDrawing = false;
            ctx.beginPath();
        }

        function draw(e) {
            if (!isDrawing) return;
            const rect = canvas.getBoundingClientRect();
            
            // حساب الإحداثيات مع مراعاة حجم الشاشة والتمرير
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            
            const x = clientX - rect.left;
            const y = clientY - rect.top;

            ctx.lineTo(x, y);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);

        canvas.addEventListener('touchstart', startDrawing);
        canvas.addEventListener('touchmove', draw);
        canvas.addEventListener('touchend', stopDrawing);

        document.getElementById('clear-btn').addEventListener('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        });

        document.getElementById('sign-form').addEventListener('submit', function(e) {
            const dataURL = canvas.toDataURL();
            document.getElementById('signature-input').value = dataURL;
        });
    </script>
</body>
</html>
