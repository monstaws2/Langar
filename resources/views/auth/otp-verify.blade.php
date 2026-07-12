<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        کد ۶ رقمی ارسال شده به {{ $phone }} را وارد کنید.
    </div>

    @if (session('error'))
        <div class="mb-4 text-sm text-red-600">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        <input type="hidden" name="phone" value="{{ $phone }}">

        <div>
            <x-input-label for="code" value="کد تایید" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" required autofocus maxlength="6" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>تایید و ورود</x-primary-button>
        </div>
    </form>
</x-guest-layout>