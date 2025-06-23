<!DOCTYPE html>
<html>

<head>
    <title>Chi tiết dịch vụ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Chi tiết dịch vụ</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>ID:</strong> {{ $service->id }}</p>
                <p><strong>Tên:</strong> {{ $service->name }}</p>
                <p><strong>Phí:</strong> {{ $service->fee }}</p>
            </div>
        </div>
        <a href="{{ route('services.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
    </div>
</body>

</html>
