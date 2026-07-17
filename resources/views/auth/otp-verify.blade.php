<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تایید کد | خانه موتور</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Vazirmatn', sans-serif; }
        .glow-card {
            box-shadow: 0 25px 50px -12px rgba(192, 57, 43, 0.35), 0 0 0 1px rgba(255,255,255,0.05);
        }
        .hero-gradient {
            background: linear-gradient(160deg, #C0392B 0%, #1A1A1A 100%);
        }
        .otp-input {
            letter-spacing: 0.75em;
            text-align: center;
        }
    </style>
</head>
<body class="bg-[#F5F5F5] min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-4xl bg-[#1A1A1A] rounded-3xl overflow-hidden glow-card flex flex-col md:flex-row-reverse">

        {{-- Photo / Hero side --}}
        <div class="hero-gradient md:w-1/2 flex flex-col items-center justify-center p-10 text-center relative overflow-hidden">
            <img src="{{ asset('images/otp-hero.png') }}" alt="خانه موتور"
                 class="absolute inset-0 w-full h-full object-cover opacity-30">
            <div class="relative z-10">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 text-white text-2xl font-bold px-6 py-3 rounded-2xl inline-block mb-4">
                     خانه‌ موتور
                </div>
                <p class="text-white text-sm max-w-xs mx-auto">
                    قطعات یدکی اصل موتورسیکلت، ارسال سریع به سراسر ایران
                </p>
            </div>
        </div>

        {{-- Form side --}}
        <div class="md:w-1/2 bg-[#F5F5F5] p-8 md:p-12 flex flex-col justify-center">

            {{-- Back link --}}
            <a href="{{ route('otp.request.form') }}" class="text-gray-500 text-sm mb-6 inline-flex items-center gap-1 hover:text-[#C0392B]">
                ← ویرایش شماره موبایل
            </a>

            <h1 class="text-[#1A1A1A] text-2xl font-bold mb-2">تایید شماره موبایل</h1>
            <p class="text-gray-500 text-sm mb-6">
                کد ۶ رقمی ارسال شده به
                <span class="font-bold text-[#1A1A1A]" dir="ltr">{{ $phone }}</span>
                را وارد کنید
            </p>

            @if (session('error'))
                <div class="mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-xl px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-700 bg-red-100 border border-red-300 rounded-xl px-4 py-3">
                    @foreach ($errors->all() as $error)
                        <p>⚠️ {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('otp.verify') }}">
                @csrf
                <input type="hidden" name="phone" value="{{ $phone }}">

                <div class="mb-6">
                    <label for="code" class="block text-gray-700 text-sm font-medium mb-2">
                        کد تایید
                    </label>
                    <input
                        id="code"
                        type="text"
                        name="code"
                        required
                        autofocus
                        maxlength="6"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        dir="ltr"
                        placeholder="------"
                        class="otp-input block w-full rounded-xl border border-gray-300 bg-white px-4 py-4 text-2xl font-bold
                               min-h-[56px] focus:outline-none focus:border-[#C0392B] focus:ring-1 focus:ring-[#C0392B]
                               placeholder-gray-300"
                    >
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>

                <button
                    type="submit"
                    class="w-full bg-[#C0392B] hover:bg-red-700 text-white font-bold text-base
                           py-3 px-6 rounded-xl min-h-[48px] transition-colors duration-200 active:scale-95
                           shadow-lg shadow-red-900/20"
                >
                    تایید و ورود
                </button>
            </form>

            <p class="text-gray-400 text-xs text-center mt-6">
                کد را دریافت نکردید؟
                <a href="{{ route('otp.request.form') }}" class="text-[#E67E22] font-medium hover:underline">
                    ارسال دوباره
                </a>
            </p>

        </div>
    </div>

</body>
</html>