<!DOCTYPE html>
<html>
<head>
    <title>Upload Excel</title>
</head>
<body>
    <h1>Upload Excel File</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('excel.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".xlsx,.xls" required>
        <input type="number" name="year" placeholder="year">
        <button type="submit">Upload</button>
    </form>
</body>
</html>
