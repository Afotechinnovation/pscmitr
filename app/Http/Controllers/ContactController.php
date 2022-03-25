<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;


class ContactController extends Controller
{

    public function index() {

        return view('pages.contact.index');
    }
    public function store(Request $request, Contact $contact) {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i',
            'message' => 'required|max:500',

        ]);

        DB::beginTransaction();
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->message = strip_tags($request->input('message'));

        $contact->save();

        $contact->send($contact);
        DB::commit();

        return redirect()->route('contact.index')->with('success', 'Contact successfully created');
    }

}
