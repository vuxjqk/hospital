<!DOCTYPE html>
<html>
<head>
    <title>Chi tiết chuyên khoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Chi tiết chuyên khoa</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>ID:</strong> {{ $specialty->id }}</p>
                <p><strong>Tên:</strong> {{ $specialty->name }}</p>
                <p><strong>Phí:</strong> {{ $specialty->fee }}</p>
            </div>
        </div>
        <a href="{{ route('specialties.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
    </div>
</body>
</html>