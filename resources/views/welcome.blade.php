<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZeitKontrakt - نظام إدارة العقود الرقمية</title>
    <!-- استدعاء معالج التنسيق الاحترافي -->
    <script src="https://tailwindcss.com"></script>
    <style>
        /* حل احتياطي محلي صارم في حال تعثر الـ CDN الخارجي لتنسيق العناصر فوراً */
        body { background-color: #f3f4f6; font-family: system-ui, -apple-system, sans-serif; }
        .max-w-4xl { max-width: 56rem; margin-left: auto; margin-right: auto; }
        .bg-white { background-color: #ffffff; }
        .rounded-xl { border-radius: 0.75rem; }
        .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .p-8 { padding: 2rem; } .p-4 { padding: 1rem; } .p-2 { padding: 0.5rem; }
        .mb-8 { margin-bottom: 2rem; } .mb-2 { margin-bottom: 0.5rem; } .mt-1 { margin-top: 0.25rem; }
        .grid { display: grid; } @media (min-width: 768px) { .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        .gap-4 { gap: 1rem; } .space-y-6 > * + * { margin-top: 1.5rem; } .space-y-4 > * + * { margin-top: 1rem; }
        .block { display: block; } .w-full { width: 100%; }
        .bg-gray-50 { background-color: #f9fafb; } .bg-blue-50\/50 { background-color: rgba(239, 246, 255, 0.5); }
        .border { border-width: 1px; } .border-gray-300 { border-color: #d1d5db; } .rounded-md { border-radius: 0.375rem; }
        .text-red-500 { color: #ef4444; text-align: right; display: block; font-size: 0.75rem; margin-top: 0.25rem; }
        .text-2xl { font-size: 1.5rem; font-weight: 700; } .text-lg { font-size: 1.125rem; font-weight: 600; }
        .text-gray-800 { color: #1f2937; } .text-gray-700 { color: #374151; } .text-gray-500 { color: #6b7280; }
        .flex { display: flex; } .justify-end { justify-content: flex-end; } .space-x-3 > * + * { margin-right: 0.75rem; }
        .bg-blue-600 { background-color: #2563eb; color: white; border: none; cursor: pointer; }
        .bg-gray-200 { background-color: #e5e7eb; color: #374151; border: none; cursor: pointer; }
    </style>
    @livewireStyles
</head>
<body class="bg-gray-100 antialiased">

    <div class="py-10 px-4">
        @livewire('contract-manager')
    </div>

    @livewireScripts
</body>
</html>
