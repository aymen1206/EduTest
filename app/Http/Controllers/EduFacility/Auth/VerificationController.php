<?php

namespace App\Http\Controllers\EduFacility\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | edu_facility that recently registered with the application. Emails may also
    | be re-sent if the edu_facility didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect edu_facilities after verification.
     *
     * @var string
     */
    protected $redirectTo = '/edu_facility';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('edu-facility.auth');
        $this->middleware('signed')->only('edu-facility.verify');
        $this->middleware('throttle:6,1')->only('edu-facility.verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user('edu-facility')->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('edu-facility.auth.verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if (! hash_equals((string) $request->route('id'), (string) $request->user('edu-facility')->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($request->user('edu-facility')->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user('edu-facility')->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($request->user('edu-facility')->markEmailAsVerified()) {
            event(new Verified($request->user('edu-facility')));
        }

        return redirect($this->redirectPath())->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user('edu-facility')->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $request->user('edu-facility')->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}
