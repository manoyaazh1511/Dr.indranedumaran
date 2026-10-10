@extends('layouts.app')

@php
$journey = [
    ['Consultation', 'users', 'History, previous tests and goals are discussed.'],
    ['Assessment', 'search', 'Hormone tests, ultrasound and semen analysis.'],
    ['Ovarian stimulation', 'sun', 'Injectable medicines, with scans to monitor growth.'],
    ['Egg retrieval', 'drop', 'A short procedure, usually under sedation.'],
    ['Fertilisation', 'flask', 'Eggs and sperm are combined in the laboratory.'],
    ['Embryo culture', 'dna', 'Embryos grow for several days under observation.'],
    ['Embryo transfer', 'baby', 'An embryo is placed in the uterus.'],
    ['Pregnancy test', 'calendar', 'A blood test about two weeks later.'],
];
$compare = [
    ['What it is', 'Prepared sperm is placed in the uterus around ovulation', 'Eggs are collected and fertilised in a laboratory; an embryo is transferred'],
    ['Where fertilisation happens', 'Inside the body', 'In the laboratory'],
    ['Medication', 'None to mild ovulation tablets or injections', 'Injectable stimulation to mature several eggs'],
    ['Procedures', 'Brief insemination, no anaesthetic', 'Egg retrieval (sedation) and embryo transfer'],
    ['Fallopian tubes', 'At least one open tube is needed', 'Can be used when tubes are blocked'],
    ['Commonly considered for', 'Mild male-factor, unexplained or ovulation-related infertility', 'Tubal factors, endometriosis, severe male factor, or after IUI has not worked'],
    ['Per-cycle chance', 'Generally lower', 'Generally higher, but varies with age and cause'],
    ['Time, cost and intensity', 'Lower', 'Higher'],
];
$tones = ['from-sky-pastel/60 via-ice-100 to-lavender-100', 'from-lavender-200/70 via-lavender-100 to-ice-100'];
@endphp

@section('content')
{{-- HERO --}}
<section class="relative overflow-hidden bg-gradient-to-br from-sky-pastel/70 via-ice-100 to-lavender-100">
    <div class="pointer-events-none absolute -left-20 top-10 h-72 w-72 rounded-full bg-white/25 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-16 bottom-0 h-80 w-80 rounded-full bg-peach-300/30 blur-3xl"></div>
    <div class="container-x relative grid items-center gap-10 py-14 sm:py-20 lg:grid-cols-12">
        <div class="lg:col-span-7">
            <nav aria-label="Breadcrumb" class="mb-5 text-xs text-mute"><ol class="flex gap-2"><li><a href="{{ route('home') }}" class="hover:text-lilac">Home</a></li><li aria-hidden="true">/</li><li aria-current="page">Fertility</li></ol></nav>
            <span class="eyebrow">Fertility &amp; reproductive care</span>
            <h1 class="text-5xl leading-[1.06] sm:text-6xl">Your journey to parenthood, explained with care</h1>
            <p class="lead mt-5 max-w-xl">{{ $page['intro'] }} Learn how fertility assessment and treatments such as IUI and IVF work, in plain language.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="#highlights" class="btn btn-primary">Explore IVF &amp; IUI <x-icon name="arrow" class="h-4 w-4" /></a>
                <a href="#journey" class="btn btn-soft">Understand the IVF journey</a>
            </div>
            <ul class="mt-8 flex flex-wrap gap-2 text-xs">
                @foreach(['Assessment', 'IUI', 'IVF', 'ICSI', 'PCOS', 'Preservation'] as $c)<li class="chip">{{ $c }}</li>@endforeach
            </ul>
        </div>
        <div class="lg:col-span-5">
            <svg viewBox="0 0 400 340" class="mx-auto w-full max-w-md" role="img" aria-label="Illustration of a cell dividing into an embryo, surrounded by soft shapes">
                <defs>
                    <radialGradient id="fg1" cx="35%" cy="30%"><stop offset="0" stop-color="#fff"/><stop offset="1" stop-color="#d3a8fb"/></radialGradient>
                    <radialGradient id="fg2" cx="35%" cy="30%"><stop offset="0" stop-color="#fff"/><stop offset="1" stop-color="#a9b8ff"/></radialGradient>
                    <radialGradient id="fg3" cx="35%" cy="30%"><stop offset="0" stop-color="#fff"/><stop offset="1" stop-color="#ffc4e3"/></radialGradient>
                </defs>
                <circle cx="200" cy="170" r="150" fill="#fff" fill-opacity=".16"/>
                <circle cx="200" cy="170" r="108" fill="#fff" fill-opacity=".14" stroke="#fff" stroke-opacity=".7" stroke-width="2"/>
                <circle cx="168" cy="150" r="46" fill="url(#fg1)" stroke="#fff" stroke-width="2"/>
                <circle cx="238" cy="148" r="42" fill="url(#fg2)" stroke="#fff" stroke-width="2"/>
                <circle cx="204" cy="206" r="40" fill="url(#fg3)" stroke="#fff" stroke-width="2"/>
                <circle cx="168" cy="150" r="14" fill="#fff" fill-opacity=".8"/><circle cx="238" cy="148" r="13" fill="#fff" fill-opacity=".8"/><circle cx="204" cy="206" r="12" fill="#fff" fill-opacity=".8"/>
                <g fill="#fff" fill-opacity=".85"><circle cx="62" cy="70" r="9"/><circle cx="338" cy="82" r="12"/><circle cx="330" cy="268" r="8"/><circle cx="76" cy="262" r="11"/></g>
                <path d="M70 70c40 20 60 40 80 70M338 82c-50 10-70 30-96 62M330 268c-40-10-90-28-110-54M76 262c40-10 80-30 110-54" fill="none" stroke="#fff" stroke-opacity=".6" stroke-width="2" stroke-dasharray="4 6"/>
            </svg>
        </div>
    </div>
</section>

<section class="border-b border-white/15 bg-ice-50 py-4">
    <p class="container-x text-center text-xs leading-relaxed text-mute"><strong class="text-heading">Educational information:</strong> this page explains fertility care in general terms. It does not confirm that any specific procedure is performed by Dr. Indhra Nedumaran — please contact the clinic about available services. No treatment can guarantee a pregnancy.</p>
</section>

{{-- IVF + IUI --}}
<section id="highlights" class="section scroll-mt-24">
    <div class="container-x">
        <div class="mx-auto max-w-2xl text-center">
            <span class="eyebrow">Featured treatments</span>
            <h2 class="h-section">IVF and IUI, step by step</h2>
            <p class="lead mt-4">The two most commonly discussed treatments, with who they may suit and what to consider.</p>
        </div>
        <div class="mt-12 space-y-10">
            @foreach($highlights as $i => $s)
                <article id="{{ $s->slug }}" class="scroll-mt-24 rounded-[2.5rem] bg-gradient-to-br {{ $tones[$i % 2] }} p-6 ring-1 ring-white/30 shadow-[0_30px_60px_-35px_rgba(107,47,176,0.6)] sm:p-10">
                    @include('partials.fertility-detail', ['s' => $s, 'link' => true])
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Other treatments --}}
@if($treatments->isNotEmpty())
<section id="treatments" class="section scroll-mt-24 bg-ice-50" x-data="{ tab: '{{ $treatments->first()->slug }}' }">
    <div class="container-x">
        <div class="mx-auto max-w-2xl text-center">
            <span class="eyebrow">Fertility treatments &amp; care</span>
            <h2 class="h-section">Every option, explained</h2>
            <p class="lead mt-4">Select a topic to see who may benefit, the basic steps, considerations and common questions.</p>
        </div>
        <div class="mt-10 flex flex-wrap justify-center gap-2" role="tablist" aria-label="Fertility treatments">
            @foreach($treatments as $s)
                <button type="button" role="tab" id="tab-{{ $s->slug }}" aria-controls="panel-{{ $s->slug }}" :aria-selected="tab === '{{ $s->slug }}'" @click="tab = '{{ $s->slug }}'"
                        class="inline-flex items-center gap-2 rounded-full px-4 py-2.5 text-sm font-semibold ring-1 ring-white/30 transition"
                        :class="tab === '{{ $s->slug }}' ? 'bg-brand-600 text-white shadow-lg' : 'bg-card text-lilac hover:bg-ice-200'">
                    <x-icon :name="$s->icon ?: 'flask'" class="h-4 w-4" />{{ \Illuminate\Support\Str::before($s->title, ' –') }}
                </button>
            @endforeach
        </div>
        <div class="mt-8">
            @foreach($treatments as $s)
                <div id="panel-{{ $s->slug }}" role="tabpanel" aria-labelledby="tab-{{ $s->slug }}" x-show="tab === '{{ $s->slug }}'" @if(! $loop->first) x-cloak @endif
                     class="rounded-[2.5rem] bg-gradient-to-br from-lavender-100 via-card to-ice-100 p-6 ring-1 ring-white/30 sm:p-10">
                    @include('partials.fertility-detail', ['s' => $s, 'link' => true])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Conditions --}}
@if($conditions->isNotEmpty())
<section id="conditions" class="section scroll-mt-24" x-data="{ tab: '{{ $conditions->first()->slug }}' }">
    <div class="container-x">
        <div class="mx-auto max-w-2xl text-center">
            <span class="eyebrow">Conditions &amp; evaluation</span>
            <h2 class="h-section">When something affects fertility</h2>
            <p class="lead mt-4">PCOS, endometriosis, male-factor infertility and repeated pregnancy loss, explained gently.</p>
        </div>
        <div class="mt-10 grid gap-3 sm:grid-cols-2 lg:grid-cols-4" role="tablist" aria-label="Fertility-related conditions">
            @foreach($conditions as $s)
                <button type="button" role="tab" id="tab-{{ $s->slug }}" aria-controls="panel-{{ $s->slug }}" :aria-selected="tab === '{{ $s->slug }}'" @click="tab = '{{ $s->slug }}'"
                        class="flex items-center gap-3 rounded-2xl p-4 text-left text-sm font-semibold ring-1 ring-white/30 transition hover:-translate-y-0.5"
                        :class="tab === '{{ $s->slug }}' ? 'bg-brand-600 text-white shadow-lg' : 'bg-card text-lilac hover:bg-ice-200'">
                    <x-icon :name="$s->icon ?: 'heart'" class="h-6 w-6 shrink-0" /><span>{{ $s->title }}</span>
                </button>
            @endforeach
        </div>
        <div class="mt-8">
            @foreach($conditions as $s)
                <div id="panel-{{ $s->slug }}" role="tabpanel" aria-labelledby="tab-{{ $s->slug }}" x-show="tab === '{{ $s->slug }}'" @if(! $loop->first) x-cloak @endif
                     class="rounded-[2.5rem] bg-gradient-to-br from-sky-pastel/50 via-ice-100 to-lavender-100 p-6 ring-1 ring-white/30 sm:p-10">
                    @include('partials.fertility-detail', ['s' => $s, 'link' => true])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- IVF journey --}}
<section id="journey" class="section scroll-mt-24 bg-ice-50">
    <div class="container-x">
        <div class="mx-auto max-w-2xl text-center">
            <span class="eyebrow">Educational timeline</span>
            <h2 class="h-section">Understanding the IVF journey</h2>
            <p class="lead mt-4">A typical cycle moves through eight stages. Timings and details vary between clinics and patients.</p>
        </div>
        <ol class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($journey as $n => [$label, $icon, $text])
                <li class="card group relative !p-5 hover:-translate-y-1">
                    <span class="absolute right-4 top-3 font-display text-5xl font-semibold text-white/20">{{ $n + 1 }}</span>
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/90 text-brand-700 transition group-hover:scale-110"><x-icon :name="$icon" class="h-6 w-6" /></span>
                    <h3 class="mt-4 text-xl">{{ $label }}</h3>
                    <p class="mt-1 text-sm text-mute">{{ $text }}</p>
                </li>
            @endforeach
        </ol>
        <p class="mt-8 text-center text-sm text-mute">Read more: <a class="font-semibold text-lilac underline underline-offset-4" href="{{ route('blogs.show', 'understanding-the-ivf-journey-from-consultation-to-pregnancy-test') }}">Understanding the IVF journey</a></p>
    </div>
</section>

{{-- Comparison --}}
<section id="compare" class="section scroll-mt-24">
    <div class="container-x">
        <div class="mx-auto max-w-2xl text-center">
            <span class="eyebrow">Comparison</span>
            <h2 class="h-section">IVF vs IUI – understanding the difference</h2>
        </div>
        <div class="mt-10 overflow-hidden rounded-3xl ring-1 ring-white/30">
            <div class="hidden grid-cols-12 bg-brand-600 text-sm font-semibold text-white md:grid">
                <div class="col-span-3 p-4">&nbsp;</div><div class="col-span-4 p-4">IUI</div><div class="col-span-5 p-4">IVF</div>
            </div>
            @foreach($compare as [$k, $iui, $ivf])
                <div class="grid grid-cols-12 border-t border-white/15 {{ $loop->even ? 'bg-ice-100/60' : 'bg-card' }}">
                    <div class="col-span-12 p-4 text-sm font-semibold text-heading md:col-span-3">{{ $k }}</div>
                    <div class="col-span-12 px-4 pb-3 text-sm text-mute md:col-span-4 md:p-4"><span class="font-semibold text-lilac md:hidden">IUI: </span>{{ $iui }}</div>
                    <div class="col-span-12 px-4 pb-4 text-sm text-mute md:col-span-5 md:p-4"><span class="font-semibold text-lilac md:hidden">IVF: </span>{{ $ivf }}</div>
                </div>
            @endforeach
        </div>
        <p class="mt-4 text-center text-xs text-mute">General comparison only. The right option depends on your own tests, age and history. <a class="text-lilac underline underline-offset-4" href="{{ route('blogs.show', 'ivf-vs-iui-understanding-the-difference') }}">Read the article</a>.</p>
    </div>
</section>

{{-- Blogs --}}
@if($posts->isNotEmpty())
<section class="section bg-ice-50">
    <div class="container-x">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div><span class="eyebrow">Learn more</span><h2 class="h-section">Fertility articles</h2></div>
            <a href="{{ route('blogs.index', ['category' => 'fertility']) }}" class="btn btn-soft">All fertility articles <x-icon name="arrow" class="h-4 w-4" /></a>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($posts as $i => $post)<x-post-card :post="$post" :tone="$i" />@endforeach
        </div>
    </div>
</section>
@endif

{{-- FAQ + CTA --}}
<section class="section">
    <div class="container-x">
        @if($faqs->isNotEmpty())
            <div class="grid gap-10 lg:grid-cols-12">
                <div class="lg:col-span-4"><span class="eyebrow">FAQs</span><h2 class="h-section">Fertility questions, answered</h2><p class="lead mt-4">Related: <a class="text-lilac underline underline-offset-4" href="{{ route('gynaecology') }}">gynaecology care</a> · <a class="text-lilac underline underline-offset-4" href="{{ route('maternity') }}">pregnancy care</a></p></div>
                <div class="lg:col-span-8"><x-faq-list :faqs="$faqs" /></div>
            </div>
        @endif
        <div class="mt-16 rounded-[2.5rem] bg-gradient-to-br from-sky-pastel/60 via-ice-100 to-lavender-100 p-10 text-center ring-1 ring-white/30">
            <h2 class="text-4xl">Have questions about your fertility?</h2>
            <p class="lead mx-auto mt-3 max-w-xl">Send an enquiry to discuss your situation and which assessments may be right for you.</p>
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="{{ route('contact') }}" class="btn btn-primary">Send an enquiry</a>
                @if(setting('whatsapp'))<a href="https://wa.me/{{ setting('whatsapp') }}" target="_blank" rel="noopener" class="btn btn-soft"><x-icon name="whatsapp" class="h-4 w-4" /> WhatsApp</a>@endif
            </div>
        </div>
    </div>
</section>
@endsection
