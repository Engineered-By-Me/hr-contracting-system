<!DOCTYPE html>
<html lang="de" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Arbeitsvertrag</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #222; line-height: 1.6; padding: 20px; }
        .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .company-name { font-size: 24px; font-weight: bold; color: #1a365d; }
        .title { font-size: 20px; font-weight: bold; margin-top: 10px; }
        .section-title { font-size: 14px; font-weight: bold; margin-top: 25px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .content { font-size: 12px; margin-top: 15px; }
        .bold { font-weight: bold; }
        .footer-table { width: 100%; margin-top: 80px; border-collapse: collapse; }
        .footer-table td { width: 50%; vertical-align: top; font-size: 12px; }
        .signature-line { border-top: 1px solid #333; width: 80%; margin-top: 50px; padding-top: 5px; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <div class="company-name">{{ $company_name }}</div>
        <div class="title">ARBEITSVERTRAG</div>
        <div style="font-size: 11px; color: #666; margin-top: 5px;">Steuernummer: {{ $tax_number }}</div>
    </div>

    <div class="content">
        <p>Zwischen der Firma <span class="bold">{{ $company_name }}</span> (nachfolgend "Arbeitgeber" genannt)</p>
        <p>und Herrn / Frau <span class="bold">{{ $candidate_name }}</span> (nachfolgend "Arbeitnehmer" genannt) wird folgender Arbeitsvertrag geschlossen:</p>

        <div class="section-title">§ 1 Beginn des Arbeitsverhältnisses und Taetigkeit</div>
        <p>Das Arbeitsverhältnis beginnt am <span class="bold">{{ $start_date }}</span>. Der Arbeitnehmer wird als <span class="bold">{{ $job_title }}</span> eingestellt.</p>

        <div class="section-title">§ 2 Verguetung</div>
        <p>Der Arbeitnehmer erhält für seine Tätigkeit ein Bruttogehalt von <span class="bold">€{{ number_format($salary, 2) }}</span> pro Jahr. Die Auszahlung erfolgt jeweils am Ende des Kalendermonats.</p>

        <div class="section-title">§ 3 Probezeit</div>
        <p>Die ersten sechs Monate des Arbeitsverhältnisses gelten als Probezeit. Während der Probezeit kann das Arbeitsverhältnis von beiden Parteien mit einer Frist von zwei Wochen gekündigt werden.</p>

        <div class="section-title">§ 4 Schlussbestimmungen</div>
        <p>Änderungen und Ergänzungen dieses Vertrages bedürfen zu ihrer Wirksamkeit der Schriftform. Sollten einzelne Bestimmungen dieses Vertrages unwirksam sein, bleibt der Vertrag im Übrigen wirksam.</p>
    </div>

    <table class="footer-table">
        <tr>
            <td>
                <div>Muenchen, am {{ date('d.m.Y') }}</div>
                <div class="signature-line">Arbeitgeber (BMW Group)</div>
            </td>
            <td>
                <div>Unterschrift am: <span style="color: #2563eb;">{{ $signed_at ? $signed_at : 'Ausstehend' }}</span></div>
                <div class="signature-line">Arbeitnehmer ({{ $candidate_name }})</div>
            </td>
        </tr>
    </table>

</body>
</html>
