<!DOCTYPE html>
<html>

<head>
  <title>User Search</title>
  <!-- Add your CSS stylesheets here -->
  <style>
    /* Add your custom CSS styles */
  </style>
</head>

<body>
  <h1>User Search</h1>

  <form action="{{ route('user.search') }}" method="POST">
    @csrf
    <input type="text" name="search" placeholder="Search for a file">
    <button type="submit">Search</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>File</th>
        <th>Uploaded By</th>
        <th>Verified By</th>
        <th>Status</th>
        <th>Feedback</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($files as $file)
      <tr>
        <td><a href="{{ route('user.view', ['filename' => $file->filename]) }}">{{ $file->original_filename }}</a></td>
        <td>{{ $file->user->name }}</td>
        <td>
          @if ($file->verified_by_admin)
          {{ $file->admin->name }}
          @else
          N/A
          @endif
        </td>
        <td>{{ $file->status }}</td>
        <td>{{ $file->feedback }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="5">No files found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <a href="{{ route('user.home') }}">Back to User Homepage</a>

</body>

</html>