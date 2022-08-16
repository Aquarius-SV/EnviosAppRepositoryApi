@component('mail::message')
# Verifica tu cuenta
 
Estas a un paso de unirte a la comunidad creciente de repartidores, mas grande de Chalatenango.
 
@component('mail::button', ['url' => $url, 'color' => 'success'])
Confirmar
@endcomponent
 
{{-- Gracias,<br> --}}
{{ config('app.name') }}
@endcomponent