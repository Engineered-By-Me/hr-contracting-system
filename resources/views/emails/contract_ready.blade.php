<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; color: #333; padding: 20px; text-align: left; }
        .card { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h2 { color: #1e3a8a; }
        .btn { display: inline-block; background-color: #16a34a; color: #ffffff !important; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 12px; color: #666; border-top: 1px solid #eee; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Hallo {{ $candidateName }},</h2>
        <p>herzlichen Glückwunsch! Dein Arbeitsvertrag bei der <strong>BMW Group Germany</strong> ist fertig gestellt.</p>
        <p>Bitte klicke auf den folgenden Button, um den Vertrag zu überprüfen und digital zu unterschreiben:</p>
        
        <!-- الزر السحري المحمل بالرابط التلقائي الموجه للموظف -->
        <a href="{{ $secureUrl }}" class="btn">Vertrag Unterschreiben ✍️</a>
        
        <p style="margin-top:20px;">Falls der Button nicht funktioniert, kopiere diesen Link in deinen Browser:<br> {{ $secureUrl }}</p>
        
        <div class="footer">
            Mit freundlichen Grüßen,<br>
            <strong>ZeitKontrakt HR System</strong>
        </div>
    </div>
</body>
</html>
