@props(['name' => ''])

@switch($name)
    @case('html-css')
        {{-- HTML5 Brand Logo (Simple Icons) --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M1.5 0h21l-1.91 21.563L11.977 24l-8.565-2.438L1.5 0zm17.09 4.413L5.41 4.41l.213 2.622 10.125.002-.296 3.48H5.854l.214 2.623h9.43l-.619 6.84-5.385 1.503-5.395-1.503-.36-4.144H3.102l.62 7.027 8.272 2.308 8.25-2.308 1.12-12.723.214-2.622-.214-.002z"/>
        </svg>
        @break

    @case('javascript')
        {{-- JavaScript Brand Logo (Simple Icons) --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M0 0h24v24H0V0zm22.034 18.276c-.175-1.095-.888-2.015-3.003-2.873-.736-.345-1.554-.585-1.797-.1.147.213.194.498.174.912-.045.922-.647 1.492-1.748 1.492-1.103 0-1.713-.574-1.713-1.42 0-.853.535-1.258 1.637-1.708l.685-.283c2.408-.99 3.518-2.013 3.518-4.148 0-2.492-1.928-3.955-4.887-3.955-2.736 0-4.52 1.378-4.862 3.863l2.84.453c.245-1.353.99-1.895 2.05-1.895.968 0 1.595.54 1.595 1.332 0 .66-.34 1.054-1.408 1.504l-.84.356c-2.492 1.053-3.612 2.155-3.612 4.385 0 2.76 2.014 4.316 5.093 4.316 3.197 0 5.178-1.534 5.37-3.834l-2.906-.395zm-9.39-9.923h-3.21v8.835c0 1.834-.847 2.47-2.32 2.47-.79 0-1.407-.156-1.797-.374l-.45 2.65c.6.286 1.484.47 2.497.47 3.328 0 5.28-1.71 5.28-5.216V8.353z"/>
        </svg>
        @break

    @case('php')
        {{-- PHP Brand Logo (Simple Icons) --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm-4.32 16.536l.78-4.272h1.272c1.332 0 2.184-.588 2.376-1.632.204-1.104-.42-1.68-1.752-1.68H7.956L6.516 16.536H7.68zm8.688 0l.78-4.272h1.272c1.332 0 2.184-.588 2.376-1.632.204-1.104-.42-1.68-1.752-1.68h-2.4l-1.44 7.584h1.164zm-3.576-1.848l1.092-5.736h-1.176l-.372 1.956h-.048c-.288-.696-.948-1.056-1.764-1.056-.996 0-1.776.54-2.136 1.512-.372 1.008-.18 2.136.456 2.892.576.684 1.344.984 2.184.984.756 0 1.38-.288 1.764-.816v.264h-.008z"/>
        </svg>
        @break

    @case('laravel')
        {{-- Laravel Brand Logo (Simple Icons) --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M22.956 5.86a.852.852 0 0 0-.41-.741L12.448.06a.885.885 0 0 0-.896 0L1.454 5.12a.853.853 0 0 0-.41.74v12.28c0 .31.16.594.41.741l10.098 5.059a.885.885 0 0 0 .896 0l10.098-5.06a.852.852 0 0 0 .41-.74V5.86zM12 1.834l8.608 4.312-3.473 1.74-8.608-4.312 3.473-1.74zm-9.198 4.61 8.32 4.168v9.112l-8.32-4.168V6.444zm18.396 9.112-8.32 4.168V10.612l8.32-4.168v9.112z"/>
        </svg>
        @break

    @case('mysql')
        {{-- MySQL Brand Logo (Simple Icons) --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M17.482 12.875c-.328-.562-.898-.828-1.78-.828-.68 0-1.336.21-1.945.609-.61.4-1.07.961-1.383 1.688l-.75 1.781c-.281.656-.68 1.148-1.195 1.476-.516.329-1.125.493-1.828.493-.89 0-1.617-.282-2.18-.844-.562-.563-.844-1.313-.844-2.25 0-.985.305-1.782.914-2.391.61-.61 1.43-1.008 2.461-1.196.446-.07.891-.046 1.336.071.446.117.844.305 1.196.562l.843-1.547c-.54-.375-1.148-.656-1.828-.844-.68-.187-1.383-.234-2.109-.14-.985.117-1.899.47-2.743 1.055-.843.586-1.5 1.36-1.968 2.32-.47.961-.703 2.04-.703 3.235 0 1.453.422 2.672 1.265 3.656.844.985 1.992 1.477 3.446 1.477 1.148 0 2.156-.282 3.023-.844.867-.563 1.523-1.36 1.969-2.391l.75-1.781c.21-.492.515-.867.914-1.125.398-.258.843-.375 1.336-.375.492 0 .82.094.984.281.164.188.234.493.21.915-.023.328-.14.726-.351 1.195l-.657 1.453 1.735.75.656-1.453c.352-.773.54-1.477.563-2.109.047-.844-.141-1.5-.563-1.969z"/>
        </svg>
        @break

    @case('figma')
        {{-- Figma Brand Logo (Simple Icons) --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M5 5.5A3.5 3.5 0 0 1 8.5 2H12v7H8.5A3.5 3.5 0 0 1 5 5.5z"/>
            <path d="M12 2h3.5a3.5 3.5 0 1 1 0 7H12V2z"/>
            <path d="M12 12.5a3.5 3.5 0 1 1 7 0 3.5 3.5 0 1 1-7 0z"/>
            <path d="M5 19.5A3.5 3.5 0 0 1 8.5 16H12v3.5a3.5 3.5 0 1 1-7 0z"/>
            <path d="M5 12.5A3.5 3.5 0 0 1 8.5 9H12v7H8.5A3.5 3.5 0 0 1 5 12.5z"/>
        </svg>
        @break

    @case('layout')
        {{-- Lucide Layout --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/>
        </svg>
        @break

    @case('users')
        {{-- Lucide Users --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        @break

    @case('pen-tool')
        {{-- Lucide Pen Tool --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="m12 19 7-7 3 3-7 7-3-3z"/><path d="m18 13-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/><path d="m2 2 7.586 7.586"/><circle cx="11" cy="11" r="2"/>
        </svg>
        @break

    @case('mouse-pointer-click')
        {{-- Lucide Mouse Pointer Click --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="m9 9 5 12 1.774-5.226L21 14 9 9z"/><path d="m16.071 16.071 4.243 4.243"/><path d="m7.188 2.239.777 2.897"/><path d="m5.136 7.965-2.898-.777"/><path d="m14 4.071 2.121-2.121"/><path d="m4.071 14-2.121 2.121"/>
        </svg>
        @break

    @case('palette')
        {{-- Lucide Palette --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
        </svg>
        @break

    @case('table')
        {{-- Lucide Table --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M12 3v18"/><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M3 15h18"/>
        </svg>
        @break

    @case('message-circle')
        {{-- Lucide Message Circle --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
        </svg>
        @break

    @case('handshake')
        {{-- Lucide Handshake --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="m11 17 2 2a1 1 0 0 0 1.4 0l4.6-4.6a2 2 0 0 0 0-2.8l-3.2-3.2a2 2 0 0 0-2.8 0L11 10.4"/><path d="m18 10 1.4-1.4a2 2 0 0 0 0-2.8l-1.2-1.2a2 2 0 0 0-2.8 0L14 6"/><path d="M17 14l-4-4"/><path d="M7 13l-4 4 6 6 4-4"/><path d="M2 17l4 4"/>
        </svg>
        @break

    @case('check-circle')
        {{-- Lucide Check Circle --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/>
        </svg>
        @break

    @case('code')
        {{-- Lucide Code --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
        </svg>
        @break

    @default
        {{-- Fallback Sparkle/Dot --}}
        <svg {{ $attributes->merge(['class' => 'shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="3"/>
        </svg>
@endswitch
