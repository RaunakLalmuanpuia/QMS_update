<?php

namespace App\Http\Controllers;


use App\Models\Admin;
use App\Models\Employee;
use App\Models\File;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function index()
    {
        // Get all admins
        $admins = Admin::all();

        // Get all employees
        $employees = Employee::all();

        // Get all files
        $files = File::all();

        return view('superadmin.index', compact('admins', 'employees', 'files'));
    }

    public function viewAdmin(Admin $admin)
    {
        // Get the admin's homepage link
        $admins = Admin::all();
        $homepageLink = route('superadmin.viewAdmin', $admin);

        return view('superadmin.show-admin', compact('admin', 'homepageLink'));
    }

    public function viewEmployee(Employee $employee)
    {
        // Get the employee's homepage link
        $homepageLink = route('superadmin.viewEmployee', $employee);

        return view('superadmin.show-employee', compact('employee', 'homepageLink'));
    }

    public function deleteAdmin(Admin $admin)
    {
        // Delete the admin
        $admin->delete();

        // Redirect back or to a success page
        return redirect()->route('superadmin.index')->with('success', 'Admin deleted successfully');
    }

    public function deleteEmployee(Employee $employee)
    {
        // Delete the associated files
        $employee->files()->delete();

        // Delete the employee
        $employee->delete();

        // Redirect back or to a success page
    }


    public function deleteFile(File $file)
    {
        // Delete the file
        $file->delete();

        // Redirect back or to a success page
        return redirect()->route('superadmin.index')->with('success', 'File deleted successfully');
    }

    public function changeFileStatus(File $file, Request $request)
    {
        // Update the file status
        return view('superadmin.change-file-status', compact('file'));

        // Redirect back or to a success page

    }
    public function updateFileStatus(File $file, Request $request)
    {
        // Update the file status
        $file->status = $request->status;
        $file->save();

        // Redirect back or to a success page
        return redirect()->route('superadmin.index')->with('success', 'File status updated successfully');
    }

    public function editFeedback(File $file)
    {
        return view('superadmin.edit-feedback', compact('file'));
    }

    public function updateFeedback(File $file, Request $request)
    {
        // Update the feedback
        $file->feedback = $request->feedback;
        $file->save();

        // Redirect back or to a success page
        return redirect()->route('superadmin.index')->with('success', 'Feedback updated successfully');
    }
}
