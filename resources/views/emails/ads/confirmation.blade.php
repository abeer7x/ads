@component('mail::message')
# مرحباً {{ $userName }}

لقد تم {{ $ad->status === 'active' ? 'قبول' : 'رفض' }} إعلانك.

---

**العنوان:** {{ $ad->title ?? 'غير متوفر' }}  
**الوصف:** {{ $ad->description ?? 'لا يوجد وصف' }}  
**السعر:** {{ $ad->price ? number_format($ad->price, 2) . ' $' : 'غير محدد' }}

---

شكراً لاستخدامك منصتنا.  
{{ config('app.name') }}
@endcomponent
