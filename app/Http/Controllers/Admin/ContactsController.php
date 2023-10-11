<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Contacts;
use Illuminate\Http\Request;

class ContactsController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Contacts::first();
        return view('admin.contact.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contacts  $Contacts
     * @return \Illuminate\Http\Response
     */
    public function show(Contacts $Contacts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contacts  $Contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(Contacts $Contacts)
    {
        $data = Contacts::first();
        return view('admin.contact.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacts  $Contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contacts $Contacts)
    {

        request()->validate([
            'phone' => 'required|min:2|max:20',
            'mobile' => 'required|min:2|max:20',
            'email' => 'required|email',
            'support' => 'required',
            'address' => 'required|min:2|max:255',
            'address_en' => 'required|min:2|max:255',
            'working_hours' => 'required|min:2|max:255',
            'working_hours_en' => 'required|min:2|max:255',
        ]);

        $contact = Contacts::first();
        $contact->phone = $request->phone;
        $contact->mobile = $request->mobile;
        $contact->email = $request->email;
        $contact->support = $request->support;
        $contact->address = $request->address;
        $contact->address_en = $request->address_en;
        $contact->working_hours = $request->working_hours;
        $contact->working_hours_en = $request->working_hours_en;

        $contact->facebook = $request->facebook;
        $contact->twitter = $request->twitter;
        $contact->insta = $request->insta;
        $contact->telegram = $request->telegram;
        $contact->youtube = $request->youtube;

        $contact->update();
        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacts  $Contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contacts $Contacts)
    {
        //
    }
}
