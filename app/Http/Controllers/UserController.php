<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
  /**
   * Show the user homepage.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    $files = File::with(['employee', 'admin'])->get();
    return view('user.home', compact('files'));
  }

  /**
   * View a file.
   *
   * @param  string  $filename
   * @return \Illuminate\Http\Response
   */
  public function viewFile($filename)
  {
    $file = File::where('filename', $filename)->first();
    $filePath = $file->file_path;
    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
    if (in_array($fileExtension, ['pdf', 'jpg', 'jpeg', 'png', 'gif'])) {
      // View the file
      return response()->file(storage_path('app/' . $filePath));
    } else {
      // Download the file with the extension name
      return Storage::download($filePath, $file->filename . '.' . $fileExtension);
    }
  }

  /**
   * Search for a file.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\View\View
   */
  public function search(Request $request)
  {
    $search = $request->input('search');
    $category = $request->input('category');

    $files = File::with(['employee', 'admin'])
      ->where(function ($query) use ($search, $category) {
        if ($category === 'filename') {
          $query->where('filename', 'LIKE', "%$search%");
        } elseif ($category === 'uploaded_by') {
          $query->whereHas('employee', function ($query) use ($search) {
            $query->where('name', 'LIKE', "%$search%");
          });
        } elseif ($category === 'verified_by') {
          $query->whereHas('admin', function ($query) use ($search) {
            $query->where('name', 'LIKE', "%$search%");
          });
        } elseif ($category === 'status') {
          $query->where('status', 'LIKE', "%$search%");
        }
      })
      ->get();

    return view('user.home', compact('files', 'search'));
  }
}
