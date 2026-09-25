<div class="max-w-4xl mx-auto my-10 p-8 bg-white rounded-xl shadow-md border border-gray-100">
    <!-- Header -->
    <div class="mb-8 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">ZeitKontrakt - إنشاء عقد عمل جديد</h2>
        <p class="text-gray-500 text-sm mt-1">أدخل بيانات الموظف وتفاصيل التعاقد لتوليد العقد آلياً.</p>
    </div>



   <!-- كود رسالة النجاح بتنسيق محلي صارم ملون ومضمون 100% -->
@if (session()->has('message'))
    <div style="margin-bottom: 1.5rem; padding: 1rem; background-color: #f0fdf4; border-left: 4px solid #22c55e; border-right: 4px solid #22c55e; border-radius: 0.375rem; text-align: right; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div style="display: flex; align-items: center; justify-content: flex-start;">
            <span style="font-size: 1.25rem; margin-left: 0.5rem;">🚀</span>
            <span style="font-weight: 600; color: #166534; font-family: system-ui, sans-serif;">
                {{ session('message') }}
            </span>
        </div>
    </div>
@endif

    <form wire:submit.prevent="createContract" class="space-y-6">
        <!-- قسم بيانات الموظف (Candidate Info) -->
        <div class="bg-gray-50 p-4 rounded-lg space-y-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">1. بيانات المتقدم للوظيفة</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">الاسم الأول</label>
                    <input type="text" wire:model="first_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">الاسم الأخير</label>
                    <input type="text" wire:model="last_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">البريد الإلكتروني</label>
                    <input type="email" wire:model="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">رقم الهاتف</label>
                    <input type="text" wire:model="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                </div>

                <!-- حقل رفع السيرة الذاتية (CV Upload) -->
<div style="margin-top: 1rem;">
    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 4px;">رفع السيرة الذاتية (CV بصيغة PDF)</label>
    <input type="file" wire:model="cv" style="display: block; width: 100%; padding: 6px; border: 1px solid #d1d5db; border-radius: 0.375rem; background-color: #fff;">
    @error('cv') <span style="color: #ef4444; font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span> @enderror
    
    <!-- مؤشر تحميل تفاعلي يظهر أثناء رفع الملف في الخلفية -->
    <div wire:loading wire:target="cv" style="color: #2563eb; font-size: 12px; margin-top: 4px;">جاري رفع الملف للسيرفر... ⏳</div>
</div>

            </div>
        </div>

        <!-- قسم تفاصيل العقد (Contract Details) -->
        <div class="bg-blue-50/50 p-4 rounded-lg space-y-4 border border-blue-100">
            <h3 class="text-lg font-semibold text-blue-800 mb-2">2. تفاصيل العقد والشروط القانونية</h3>
            
            <div>
                <label class="block text-sm font-medium text-gray-600">المسمى الوظيفي (Title)</label>
                <input type="text" wire:model="title" placeholder="مثال: Senior PHP Developer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">الراتب السنوي الإجمالي (€ Brutto)</label>
                    <input type="number" wire:model="salary" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    @error('salary') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">تاريخ بدء العمل (Start Date)</label>
                    <input type="date" wire:model="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                    @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- أزرار التحكم -->
        <div class="flex justify-end space-x-3 rtl:space-x-reverse pt-4 border-t">
            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">إلغاء</button>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 shadow-md font-medium transition">
                توليد العقد وإرساله للتوقيع 🚀
            </button>
        </div>
    </form>
</div>
