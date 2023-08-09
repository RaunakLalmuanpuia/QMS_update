<?php


namespace App\Http\Controllers;



use App\Models\File;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee;
use App\Mail\RegistrationApproval;
use App\Mail\RegistrationRejection;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['showRegistrationForm', 'register', 'showLoginForm', 'login', 'verifyOtp']);
    }
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'department' => 'required',
            'post' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6|confirmed',
            'contact_number' => 'required',
            'address' => 'required',
        ]);

        // Create a new admin
        $validatedData['password'] = bcrypt($validatedData['password']);
        Admin::create($validatedData);


        // Redirect to a success page or perform additional actions

        return redirect()->route('admin.register')->with('success', 'Admin registered successfully.');
    }

    // Admin Login

    public function showLoginForm()
    {
        return view('admin.login');
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
        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            // Invalid email or password
            return back()->withErrors(['email' => 'Invalid email or password']);
        }
        Auth::guard('admin')->login($admin);
        $otp = $this->generateOTP();

        try {
            $this->sendOTP($admin->email, $otp);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send OTP']);
        }

        $request->session()->put('otp', $otp);
        $request->session()->put('admin_id', $admin->id);

        return redirect()->route('admin.login')->with('email_sent', true);
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $otp = $request->session()->get('otp');
        $adminId = $request->session()->get('admin_id');

        if ($otp && strval($otp) === $request->otp) {
            // OTP verification successful
            $admin = Admin::find($adminId);
            // Auth::guard('admin')->login($admin);
            $request->session()->forget('otp');
            $request->session()->forget('admin_id');

            return redirect()->route('admin.dashboard', ['name' => auth()->guard('admin')->user()->name]);
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
    public function dashboard()
    {
        $name = auth()->user()->name; // Get the name of the authenticated admin
        $adminId = auth()->user()->id;
        $pendingFiles = File::where('status', 'pending')->get();
        $verifiedFiles = File::where('admin_id', $adminId)
            ->whereIn('status', ['accepted', 'rejected'])
            ->get();
        return view('admin.dashboard', compact('name', 'pendingFiles', 'verifiedFiles'));
    }


    public function verifyFile(Request $request, $id)
    {
        $file = File::findOrFail($id);
        $adminId = auth()->user()->id;

        // Make sure the file is pending
        if ($file->status === 'pending') {
            $file->status = $request->input('status');
            $file->feedback = $request->input('feedback');
            $file->admin_id = $adminId;
            $file->save();

            return redirect()->back()->with('success', 'File verified successfully');
        } else {
            return redirect()->back()->with('error', 'Unauthorized');
        }
    }
    public function verifiedFiles()
    {
        $adminId = auth()->user()->id;
        $verifiedFiles = File::where('admin_id', $adminId)
            ->whereIn('status', ['accepted', 'rejected'])
            ->get();



        return view('admin.dashboard',  compact('verifiedFiles'));
    }
    public function viewFile($id)
    {
        $file = File::findOrFail($id);

        // View the file
        return Storage::response($file->file_path);
    }
    public function deleteFile($id)
    {
        $file = File::findOrFail($id);

        // Make sure the file belongs to the authenticated employee
        if ($file->admin_id === auth()->user()->id) {
            // Update the status of the file to 'removed'
            $file->update(['deleted_by_admin' => 'removed']);


            return redirect()->back()->with('success', 'File deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Unauthorized');
        }
    }
    //Approval
    public function employeeApproval()
    {
        $employees = Employee::where('status', 'pending')->get();
        $approvedEmployees = Employee::where('status', 'approved')->get();

        return view('admin.employee-approval', [
            'employees' => $employees,
            'approvedEmployees' => $approvedEmployees
        ]);
    }
    public function approveEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = 'approved';
        $employee->save();

        Mail::to($employee->email)->send(new RegistrationApproval($employee));

        return redirect()->back()->with('success', 'Employee approved successfully.');
    }
    public function rejectEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = 'rejected';
        $employee->save();

        Mail::to($employee->email)->send(new RegistrationRejection($employee));

        return redirect()->back()->with('success', 'Employee rejected successfully.');
    }
}
