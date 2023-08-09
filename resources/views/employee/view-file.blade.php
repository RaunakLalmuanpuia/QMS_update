<!-- view-file.blade.php -->
<h2>View File</h2>

@php
$fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
@endphp

@if (in_array($fileExtension, ['pdf', 'jpg', 'jpeg', 'png', 'gif']))
<!-- Display PDF or image file -->
<embed src="{{ asset($filePath) }}" type="application/pdf" width="100%" height="600px" />
@else
<!-- Display generic file link -->
<a href="{{ asset($filePath) }}" download>Download File</a>
@endif