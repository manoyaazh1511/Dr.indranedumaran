@php
    $who = $s->lines('who_for');
    $steps = $s->lines('steps');
    $cons = $s->lines('considerations');
@endphp
<div>
    @unless($bare ?? false)
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div class="flex items-center gap-4">
            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/90 text-brand-700 shadow-sm"><x-icon :name="$s->icon ?: 'flask'" class="h-7 w-7" /></span>
            <h3 class="text-3xl leading-tight sm:text-4xl">{{ $s->title }}</h3>
        </div>
        @if($s->is_educational)<span class="chip">Educational information</span>@endif
    </div>
    <div class="rich mt-5 !text-base">{!! $s->body !!}</div>
    @endunless

    <div class="{{ ($bare ?? false) ? 'mt-2' : 'mt-8' }} grid gap-5 md:grid-cols-3">
        @if($who)
            <div class="rounded-3xl bg-white/10 p-5 ring-1 ring-white/25">
                <h4 class="flex items-center gap-2 text-lg font-semibold"><x-icon name="users" class="h-5 w-5 text-peach-300" /> Who may benefit</h4>
                <ul class="mt-3 space-y-2 text-sm text-mute">@foreach($who as $l)<li class="flex gap-2"><x-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-peach-300" />{{ $l }}</li>@endforeach</ul>
            </div>
        @endif
        @if($steps)
            <div class="rounded-3xl bg-white/10 p-5 ring-1 ring-white/25">
                <h4 class="flex items-center gap-2 text-lg font-semibold"><x-icon name="list" class="h-5 w-5 text-peach-300" /> Basic steps</h4>
                <ol class="mt-3 space-y-2 text-sm text-mute">@foreach($steps as $n => $l)<li class="flex gap-3"><span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-white/90 text-[11px] font-bold text-brand-700">{{ $n + 1 }}</span>{{ $l }}</li>@endforeach</ol>
            </div>
        @endif
        @if($cons)
            <div class="rounded-3xl bg-white/10 p-5 ring-1 ring-white/25">
                <h4 class="flex items-center gap-2 text-lg font-semibold"><x-icon name="shield" class="h-5 w-5 text-peach-300" /> Considerations</h4>
                <ul class="mt-3 space-y-2 text-sm text-mute">@foreach($cons as $l)<li class="flex gap-2"><x-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-peach-300" />{{ $l }}</li>@endforeach</ul>
            </div>
        @endif
    </div>

    @if($s->faqs->isNotEmpty())
        <div class="mt-6 divide-y divide-white/20 rounded-3xl bg-white/10 ring-1 ring-white/25">
            @foreach($s->faqs as $faq)
                <details class="group px-5 py-4">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-sm font-semibold text-heading">
                        <span>{{ $faq->question }}</span><x-icon name="plus" class="h-4 w-4 shrink-0 transition group-open:rotate-45" />
                    </summary>
                    <p class="mt-3 text-sm leading-relaxed text-mute">{{ $faq->answer }}</p>
                </details>
            @endforeach
        </div>
    @endif

    @if($link ?? false)
        <a href="{{ route('fertility.show', $s->slug) }}" class="btn btn-soft mt-6">Read the full {{ \Illuminate\Support\Str::before($s->title, ' –') }} guide <x-icon name="arrow" class="h-4 w-4" /></a>
    @endif
</div>
