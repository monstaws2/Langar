<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // TODO: Send email or save to database
        // Mail::send('emails.contact', $validated, function ($message) {
        //     $message->to(config('mail.from.address'));
        // });

        return redirect()->back()->with('success', 'پیام شما با موفقیت ارسال شد.');
    }
}
