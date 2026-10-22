@php($banner = $banners->values()->get($bannerIndex) ?? $banners->first())
@if ($banner)
    @php($bannerImage = $banner->getFirstMedia('banner-image'))
    <section
        aria-label="Акции и специальные предложения"
        aria-roledescription="карусель"
        class="relative mb-10 overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-stone-200/80 sm:rounded-[2rem]"
    >
        <div wire:key="promotion-banner-{{ $banner->id }}" class="relative">
            <div class="relative flex w-full items-center justify-center overflow-hidden bg-gradient-to-br from-emerald-50 via-stone-50 to-amber-50" style="height: 230px;">
                <div class="pointer-events-none absolute -left-16 -top-20 h-56 w-56 rounded-full bg-emerald-200/30 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-20 right-1/4 h-56 w-56 rounded-full bg-amber-200/30 blur-3xl"></div>

                @if ($banner->hasMedia('banner-image') || $banner->image_path)
                    <img
                        src="{{ $bannerImage ? '/storage/' . $bannerImage->getPathRelativeToRoot('catalog') : '/storage/' . ltrim($banner->image_path, '/') }}"
                        alt="{{ $banner->title }}"
                        loading="lazy"
                        decoding="async"
                        class="relative object-fill"
                        style="display: block; width: 100%; height: 100%;"
                    >
                @else
                    <div class="relative text-7xl sm:text-8xl" aria-hidden="true">🍣</div>
                @endif

                @if ($banners->count() > 1)
                    <button
                        type="button"
                        wire:click="previousBanner"
                        aria-label="Предыдущий слайд"
                        class="absolute left-3 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-stone-800 shadow-lg ring-1 ring-black/5 backdrop-blur transition hover:scale-105 hover:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 sm:left-5 sm:h-12 sm:w-12"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" /></svg>
                    </button>
                    <button
                        type="button"
                        wire:click="nextBanner"
                        aria-label="Следующий слайд"
                        class="absolute right-3 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-stone-800 shadow-lg ring-1 ring-black/5 backdrop-blur transition hover:scale-105 hover:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 sm:right-5 sm:h-12 sm:w-12"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" /></svg>
                    </button>
                @endif
            </div>

            <div class="flex flex-col gap-3 px-5 py-5 sm:px-8 sm:py-6 lg:flex-row lg:items-center lg:justify-between lg:gap-8">
                <div class="min-w-0">
                    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-amber-900">Специальное предложение</span>
                    <h2 class="mt-2 text-xl font-extrabold tracking-tight text-stone-950 sm:text-2xl">{{ $banner->title }}</h2>
                    @if ($banner->description)
                        <p class="mt-2 max-w-3xl whitespace-pre-line text-sm leading-6 text-stone-600 sm:text-base">{{ $banner->description }}</p>
                    @endif
                </div>

                @if ($banner->button_label && $banner->button_url)
                    <a
                        href="{{ $banner->button_url }}"
                        target="{{ str_starts_with($banner->button_url, 'http') ? '_blank' : '_self' }}"
                        rel="{{ str_starts_with($banner->button_url, 'http') ? 'noopener noreferrer' : '' }}"
                        class="inline-flex shrink-0 items-center justify-center rounded-xl bg-emerald-900 px-5 py-3 text-sm font-extrabold text-white transition hover:-translate-y-0.5 hover:bg-emerald-800"
                    >
                        {{ $banner->button_label }}
                    </a>
                @endif
            </div>
        </div>

        @if ($banners->count() > 1)
            <div class="flex justify-center gap-2 border-t border-stone-100 py-3" aria-label="Выбрать слайд">
                @foreach ($banners as $index => $item)
                    <button
                        type="button"
                        wire:click="$set('bannerIndex', {{ $index }})"
                        aria-label="Слайд {{ $index + 1 }}"
                        aria-current="{{ $index === $bannerIndex ? 'true' : 'false' }}"
                        class="h-2.5 rounded-full transition-all {{ $index === $bannerIndex ? 'w-7 bg-emerald-800' : 'w-2.5 bg-stone-300 hover:bg-stone-400' }}"
                    ></button>
                @endforeach
            </div>
        @endif
    </section>
@endif
