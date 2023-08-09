<h1>Delete File</h1>

<p>Are you sure you want to delete this file?</p>
<p>File Name: {{ $file->name }}</p>

<form action="{{ route('superadmin.deleteFile', $file) }}" method="POST">
  @csrf
  @method('DELETE')
  <button type="submit">Delete File</button>
</form>