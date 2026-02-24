@extends('layouts.main')

@section('title', $page->title . ' - ' . config('app.name'))

@section('content')
    <main class="pt-32 pb-20 px-6">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl font-black text-slate-900 mb-6">{{ $page->title }}</h1>
            <div class="prose max-w-none">
                {!! $page->content !!}
            </div>
        </div>
    </main>
@endsection

