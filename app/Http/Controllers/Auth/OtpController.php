<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SmsOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.otp-request');
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        $code = (string) random_int(100000, 999999);

        SmsOtp::create([
            'phone' => $request->phone,
            'code' => $code,
            'expires_at' => now()->addMinutes(5),
        ]);

        app(\App\Services\SmsService::class)->sendOtp($request->phone, $code);

        return redirect()->route('otp.verify.form', ['phone' => $request->phone])
            ->with('success', 'کد تایید ارسال شد.');
    }

    public function showVerifyForm(Request $request)
    {
        return view('auth.otp-verify', ['phone' => $request->query('phone')]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'code' => 'required|string|max:6',
        ]);

        $otp = SmsOtp::where('phone', $request->phone)
            ->where('code', $request->code)
            ->where('is_used', false)
            ->where('expires_at', '>=', now())
            ->latest()
            ->first();

        if (! $otp) {
            return back()->with('error', 'کد نامعتبر یا منقضی شده است.')->withInput();
        }

        $otp->update(['is_used' => true]);

        $user = User::firstOrCreate(
            ['phone' => $request->phone],
            ['name' => 'کاربر', 'password' => bcrypt(str()->random(16))]
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}