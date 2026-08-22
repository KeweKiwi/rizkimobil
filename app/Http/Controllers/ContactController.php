<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
            'car_id' => 'nullable|exists:cars,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Contact::create($validator->validated());

            return redirect()->back()->with('success', 'Pesan berhasil dikirim. Tim Rizki Mobil akan menghubungi Anda secepatnya.');
        } catch (\Exception $e) {
            Log::error('Contact form submission failed.', [
                'exception' => $e::class,
                'code' => (string) $e->getCode(),
            ]);

            return redirect()->back()
                ->with('error', 'Maaf, pesan belum bisa dikirim. Silakan coba lagi atau hubungi kami melalui WhatsApp.')
                ->withInput();
        }
    }
}
