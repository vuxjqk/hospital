<!DOCTYPE html>
<html>

<head>
    <title>Thêm dịch vụ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Thêm dịch vụ</h1>
        <form method="POST" action="{{ route('services.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phí</label>
                <input type="number" name="fee" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('services.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>

</html>
