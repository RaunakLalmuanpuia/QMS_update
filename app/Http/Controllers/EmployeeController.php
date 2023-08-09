<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\File;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee')->except(['showRegistrationForm', 'register', 'showLoginForm', 'login', 'dashboard','verifyOtp']);
    }

    //
    public function showRegistrationForm()
    {
        return view('employee.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'department' => 'required',
            'post' => 'required',
            'email' => 'required|email|unique:employee',
            'password' => 'required|min:6|confirmed',
            'contact_number' => 'required',
            'address' => 'required',
        ]);

        // Create a new employee
        $validatedData['password'] = bcrypt($validatedData['password']);
        Employee::create($validatedData);

        // Redirect to a success page or perform additional actions

        return redirect()->route('employee.register')->with('success', 'Employee registered successfully.');
    }

    // Employee login
    public function showLoginForm()
    {
        return view('employee.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::guard('superadmin')->attempt($credentials)) {
            return redirect()->route('superadmin.index');
        }

        $employee = Employee::where('email', $credentials['email'])->first();

        if (!$employee || !Hash::check($credentials['password'], $employee->password)) {
            // Invalid email or password
            return back()->withErrors(['email' => 'Invalid email or password']);
        }

        if ($employee->status === 'approved') {
            Auth::guard('employee')->login($employee);
            $otp = $this->generateOTP();

            try {
                $this->sendOTP($employee->email, $otp);
            } catch (\Exception $e) {
                return back()->withErrors(['email' => 'Failed to send OTP']);
            }

            $request->session()->put('otp', $otp);
            $request->session()->put('employee_id', $employee->id);

            return redirect()->route('employee.login')->with('email_sent', true);
        } elseif ($employee->status === 'rejected') {
            // Account rejected
            return back()->withErrors(['email' => 'Your account has been rejected.']);
        } else {
            // Account status not recognized
            return back()->withErrors(['email' => 'Your account status is not recognized.']);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $otp = $request->session()->get('otp');
        $employeeId = $request->session()->get('employee_id');

        if ($otp && strval($otp) === $request->otp) {
            // OTP verification successful
            $employee = Employee::find($employeeId);
            // Auth::guard('employee')->login($employee);
            $request->session()->forget('otp');
            $request->session()->forget('employee_id');

            return redirect()->route('employee.dashboard', ['name' => auth()->guard('employee')->user()->name]);
        } else {
            // Invalid OTP
            return back()->withErrors(['otp' => 'Invalid OTP']);
        }
    }
    private function generateOTP()
    {
        // Generate and return the OTP
        return mt_rand(100000, 999999);
    }

    private function sendOTP($email, $otp)
    {
        // Send the OTP via email
        Mail::raw("Your OTP: $otp", function ($message) use ($email) {
            $message->to($email)->subject('OTP Verification');
        });
    }

    public function dashboard($name)
    {
        $employee = Employee::where('name', $name)->first();

        if (!$employee) {
            // Handle the case when the employee is not found
            return redirect()->back()->with('error', 'Employee not found');
        }

        $files = $employee->files;

        // Pass the files to the view
        return view('employee.dashboard', compact('name', 'files'));
    }

    public function uploadFile(Request $request)
    {
        // Validate the uploaded file and filename
        $request->validate([
            'file' => 'required|file',
            'filename' => 'required|string',
        ]);

        // Store the uploaded file
        $file = $request->file('file');
        $filePath = $file->store('public/files');

        // Create a new file record in the database
        $fileRecord = new File([
            'employee_id' => auth()->user()->id,
            'file_path' => $filePath,
            'filename' => $request->input('filename'),
            'status' => 'pending',
        ]);
        $fileRecord->save();

        return redirect()->back()->with('success', 'File uploaded successfully');
    }
    public function deleteFile($id)
    {
        $file = File::findOrFail($id);

        // Make sure the file belongs to the authenticated employee
        if ($file->employee_id === auth()->user()->id) {
            // Update the status of the file to 'removed'
            $file->update(['deleted_by_employee' => 'removed']);


            return redirect()->back()->with('success', 'File deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Unauthorized');
        }
    }
    public function viewFile($id)
    {
        $file = File::findOrFail($id);

        // Make sure the file belongs to the authenticated employee
        if ($file->employee_id === auth()->user()->id) {
            $filePath = $file->file_path;
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

            // Render the appropriate view or download the file based on the extension
            if (in_array($fileExtension, ['pdf', 'jpg', 'jpeg', 'png', 'gif'])) {
                // View the file
                return response()->file(storage_path('app/' . $filePath));
            } else {
                // Download the file with the extension name
                return Storage::download($filePath, $file->filename . '.' . $fileExtension);
            }
        } else {
            return redirect()->back()->with('error', 'Unauthorized');
        }
    }
}
