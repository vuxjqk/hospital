<!DOCTYPE html>
<html>

<head>
    <title>Sửa dịch vụ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Sửa dịch vụ</h1>
        <form method="POST" action="{{ route('services.update', $service) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phí</label>
                <input type="number" name="fee" class="form-control" value="{{ $service->fee }}">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('services.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>

</html>
