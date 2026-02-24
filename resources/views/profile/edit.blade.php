@extends('layouts.main')

@section('title', 'Edit Profil | NorthSumateraTrip')

@section('content')
    <main class="pt-32 pb-20 px-6">
        <div class="max-w-4xl mx-auto space-y-8">
            <div class="reveal">
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tight">Pengaturan <span class="text-blue-700">Profil</span></h1>
                <p class="text-slate-500 font-medium">Kelola informasi akun dan keamanan Anda di sini.</p>
            </div>

            <div class="bg-white p-8 md:p-12 rounded-[40px] shadow-xl border border-slate-100 reveal">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white p-8 md:p-12 rounded-[40px] shadow-xl border border-slate-100 reveal">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-rose-50 p-8 md:p-12 rounded-[40px] shadow-xl border border-rose-100 reveal">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </main>
@endsection
