@props(['packages' => [], 'title' => null, 'subtitle' => null])

<section class="py-16 md:py-24 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        @if($title || $subtitle)
            <div class="text-center mb-12 md:mb-16">
                @if($title)
                    <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold text-slate-900 dark:text-white mb-4">
                        {{ $title }}
                    </h2>
                @endif
                @if($subtitle)
                    <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 font-light max-w-3xl mx-auto">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @forelse($packages as $package)
                <x-tour-packages.package-card :package="$package" />
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400 dark:text-slate-500 text-lg">
                        {{ __('No tour packages available at the moment.') }}
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</section>
