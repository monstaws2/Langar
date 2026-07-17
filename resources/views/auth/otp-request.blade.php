<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود | خانه موتور</title>
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

            <h1 class="text-[#1A1A1A] text-2xl font-bold mb-2">ورود به حساب کاربری</h1>
            <p class="text-gray-500 text-sm mb-6">
                نام و شماره موبایل خود را وارد کنید تا کد تایید برایتان ارسال شود
            </p>

            @if (session('success'))
                <div class="mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-xl px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

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

            <form method="POST" action="{{ route('otp.send') }}">
                @csrf

                {{-- Name Field --}}
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-medium mb-2">
                        نام و نام خانوادگی
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="مثلاً: علی رضایی"
                        class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-base
                               min-h-[48px] focus:outline-none focus:border-[#C0392B] focus:ring-1 focus:ring-[#C0392B]
                               placeholder-gray-400"
                    >
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Phone Field --}}
                <div class="mb-6">
                    <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">
                        شماره موبایل
                    </label>
                    <input
                        id="phone"
                        type="tel"
                        name="phone"
                        value="{{ old('phone') }}"
                        required
                        placeholder="۰۹۱۲۳۴۵۶۷۸۹"
                        dir="ltr"
                        class="block w-full text-right rounded-xl border border-gray-300 bg-white px-4 py-3 text-base
                               min-h-[48px] focus:outline-none focus:border-[#C0392B] focus:ring-1 focus:ring-[#C0392B]
                               placeholder-gray-400"
                    >
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <button
                    type="submit"
                    class="w-full bg-[#C0392B] hover:bg-red-700 text-white font-bold text-base
                           py-3 px-6 rounded-xl min-h-[48px] transition-colors duration-200 active:scale-95
                           shadow-lg shadow-red-900/20"
                >
                    ارسال کد تایید
                </button>
            </form>

        </div>
    </div>

</body>
</html>