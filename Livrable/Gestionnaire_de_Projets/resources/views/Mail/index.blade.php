@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            Messagerie ISOPROM
        @endcomponent
    @endslot
{{-- Body --}}
    Gestion des messages {{ $user }}
{{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset
{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
        Tous droits réservés {{ date('Y') }} {{ config('app.name') }}. ISOPROM
        @endcomponent
    @endslot
@endcomponent
