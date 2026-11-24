@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto grid lg:grid-cols-2 rounded-[28px] sm:rounded-[36px] overflow-hidden bg-white shadow-soft">
    <!-- Artwork panel -->
    <div class="hidden lg:block relative bg-peach">
        <img src="{{ \App\Support\Img::lg('easy_puzzle_3_cover.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover">
        <span class="absolute left-6 top-6 bg-sun text-ink font-bold text-[12px] uppercase tracking-wider px-4 py-2 rounded-full shadow-soft -rotate-2">Join 800byPD Family</span>
    </div>

    <!-- Form panel -->
    <div class="p-6 sm:p-12">
        <div class="mb-8">
            <span class="lg:hidden inline-block bg-sun text-ink font-bold text-[11px] uppercase tracking-wider px-3 py-1.5 rounded-full mb-4">Join 800byPD Family</span>
            <h1 class="font-fun text-[32px] sm:text-[40px] font-semibold text-ink leading-tight">Create Account</h1>
            <p class="text-[14px] text-slate-500 mt-1">Sign up to track your orders & fast-track checkout</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-rose-50 text-rose-800 p-4 rounded-2xl text-[13px] space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center gap-1.5"><i class="bi bi-exclamation-triangle-fill text-rose-500"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="field-label">Full Name</label>
                <div class="relative">
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Pastor Paul" class="field !pl-11">
                    <i class="bi bi-person-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="field-label">Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com" class="field !pl-11">
                        <i class="bi bi-envelope-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    </div>
                </div>
                <div>
                    <label class="field-label">Phone Number</label>
                    <div class="relative">
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="0816 425 4442" class="field !pl-11">
                        <i class="bi bi-telephone-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    </div>
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="field-label">Password</label>
                    <div class="relative">
                        <input type="password" name="password" required placeholder="Minimum 6 characters" class="field !pl-11">
                        <i class="bi bi-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    </div>
                </div>
                <div>
                    <label class="field-label">Confirm Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" required placeholder="Re-enter password" class="field !pl-11">
                        <i class="bi bi-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    </div>
                </div>
            </div>
            <button type="submit" class="w-full bg-ink hover:bg-inkdeep text-white font-bold h-[52px] rounded-full shadow-lift transition flex items-center justify-center gap-2 text-[15px] !mt-6">
                <i class="bi bi-person-plus-fill text-sun"></i> Create Account
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-ink/10 text-[14px] text-slate-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-grape font-bold hover:underline">Log In Here</a>
        </div>
    </div>
</div>
@endsection
