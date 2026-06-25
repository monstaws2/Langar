@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">تماس با ما</h1>
        <p class="text-gray-600 mt-2">ما اینجا هستیم تا کمک کنیم</p>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contact Information -->
        <div>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">اطلاعات تماس</h3>

                <!-- Phone -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 mb-2">تلفن</h4>
                    <p class="text-gray-600">
                        <a href="tel:+989991234567" class="hover:text-red-600 transition">09991234567</a>
                    </p>
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 mb-2">ایمیل</h4>
                    <p class="text-gray-600">
                        <a href="mailto:info@langarmotor.ir" class="hover:text-red-600 transition">info@langarmotor.ir</a>
                    </p>
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 mb-2">آدرس</h4>
                    <p class="text-gray-600">
                        تهران، خیابان آزادی، ساختمان لنگر موتور
                    </p>
                </div>

                <!-- Hours -->
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">ساعات کاری</h4>
                    <p class="text-gray-600">
                        شنبه تا پنجشنبه: 9:00 - 18:00<br>
                        جمعه: تعطیل
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">پیام خود را ارسال کنید</h3>

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-gray-700 font-semibold mb-2">نام</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600 @error('name') border-red-600 @enderror" placeholder="نام خود را وارد کنید">
                        @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-gray-700 font-semibold mb-2">ایمیل</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600 @error('email') border-red-600 @enderror" placeholder="ایمیل خود را وارد کنید">
                        @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-gray-700 font-semibold mb-2">تلفن</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600 @error('phone') border-red-600 @enderror" placeholder="شماره تلفن خود را وارد کنید">
                        @error('phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-gray-700 font-semibold mb-2">موضوع</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600 @error('subject') border-red-600 @enderror" placeholder="موضوع پیام">
                        @error('subject')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-gray-700 font-semibold mb-2">پیام</label>
                        <textarea id="message" name="message" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600 @error('message') border-red-600 @enderror" placeholder="پیام خود را وارد کنید"></textarea>
                        @error('message')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                        ارسال پیام
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
