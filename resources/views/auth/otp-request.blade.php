<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        شماره موبایل خود را وارد کنید تا کد تایید برایتان ارسال شود.
    </div>

    @if (session('success'))
        <div class="mb-4 text-sm text-green-600">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="mb-4 text-sm text-red-600">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('otp.send') }}">
        @csrf

        <div>
            <x-input-label for="phone" value="شماره موبایل" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" value="{{ old('phone') }}" required autofocus placeholder="09123456789" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>ارسال کد تایید</x-primary-button>
        </div>
    </form>
</x-guest-layout>