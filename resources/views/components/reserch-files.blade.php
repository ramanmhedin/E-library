{{-- resources/views/components/research-files.blade.php --}}
@foreach ($files as $file)
    <a href="{{ Storage::disk('public')->url($file->path) }}" target="_blank">{{ $file->original_name }}</a><br>
@endforeach
