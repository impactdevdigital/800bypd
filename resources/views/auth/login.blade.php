@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto grid lg:grid-cols-2 rounded-[28px] sm:rounded-[36px] overflow-hidden bg-white shadow-soft">
    <!-- Artwork panel -->
    <div class="hidden lg:block relative bg-lilac">
        <img src="{{ \App\Support\Img::lg('easy_puzzle_2_cover.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-x-6 bottom-6 bg-white/95 rounded-2xl p-4 shadow-lift flex items-center gap-3">
            <div class="w-11 h-11 bg-sun text-ink rounded-xl flex items-center justify-center font-fun font-bold text-xl rotate-3 flex-shrink-0">8</div>
            <div>
                <div class="font-fun text-ink font-semibold text-[17px] leading-tight">800BY<span class="text-amber-500">PD</span></div>
                <div class="text-[12px] text-slate-500">Faith & Learning for Kids</div>
            </div>
        </div>
    </div>

    <!-- Form panel -->
    <div class="p-6 sm:p-12">
        <div class="mb-8">
            <div class="w-14 h-14 bg-ink text-sun rounded-2xl flex items-center justify-center font-fun font-bold text-2xl mb-5 rotate-3 lg:hidden">8</div>
            <h1 class="font-fun text-[32px] sm:text-[40px] font-semibold text-ink leading-tight">Welcome Back</h1>
            <p class="text-[14px] text-slate-500 mt-1">Log in to view your orders and account details</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-rose-50 text-rose-800 p-4 rounded-2xl text-[13px] space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center gap-1.5"><i class="bi bi-exclamation-triangle-fill text-rose-500"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="field-label">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com" class="field !pl-11">
                    <i class="bi bi-envelope-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                </div>
            </div>
            <div>
                <label class="field-label">Password</label>
                <div class="relative">
                    <input type="password" name="password" required placeholder="Enter your password" class="field !pl-11">
                    <i class="bi bi-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                </div>
            </div>
            <label class="flex items-center gap-2 cursor-pointer text-[13px] text-slate-600 w-fit">
                <input type="checkbox" name="remember" class="w-4 h-4 accent-[#7C3AED]">
                <span>Remember me</span>
            </label>
            <button type="submit" class="w-full bg-ink hover:bg-inkdeep text-white font-bold h-[52px] rounded-full shadow-lift transition flex items-center justify-center gap-2 text-[15px] !mt-6">
                <i class="bi bi-box-arrow-in-right text-sun"></i> Log In
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-ink/10 text-[14px] text-slate-500">
            Don't have an account yet?
            <a href="{{ route('register') }}" class="text-grape font-bold hover:underline">Create Account</a>
        </div>
    </div>
</div>
@endsection
