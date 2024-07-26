<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {

        if (Auth::check()) {
            // Redirect authenticated users to the dashboard
            return redirect()->route('dashboard');
        }

        if ($request->isMethod('post')) {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
              // Attempt to authenticate the user
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                // Authentication passed
                return redirect()->intended('dashboard');
            }

            // Authentication failed
            return redirect()->back()
                ->withErrors(['error' => 'The provided credentials do not match our records.'])
                ->withInput();
        }
        
        return view("Login");
    }

    public function dashboard(Request $request)
    {
        $query = Employee::query();

        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $query->where('name', 'like', "%{$filter}%")
                  ->orWhere('contact_number', 'like', "%{$filter}%")
                  ->orWhere('email', 'like', "%{$filter}%");
        }

        $employees = $query->paginate(10);
        // Return the dashboard view
        return view('dashboard', compact('employees'));
    }

    public function logout()
    {
        // Log out the user
        Auth::logout();

        // Redirect to the login page
        return redirect()->route('login')->with('status', 'You have been logged out.');
    }
    
}
