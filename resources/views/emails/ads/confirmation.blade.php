@component('mail::message')
# مرحباً {{ $userName ?? 'مستخدم' }}

لقد تم استلام إعلانك بنجاح!

---

**العنوان:** {{ $adTitle ?? 'غير متوفر' }}  
**الوصف:** {{ $adDescription ?? 'لا يوجد وصف' }}  
**السعر:** {{ isset($adPrice) ? number_format($adPrice, 2) . ' $' : 'غير محدد' }}

---

شكراً لاستخدامك منصتنا.

{{ config('app.name') }}
@endcomponent
