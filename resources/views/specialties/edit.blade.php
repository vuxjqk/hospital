<!DOCTYPE html>
<html>
<head>
    <title>Sửa chuyên khoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Sửa chuyên khoa</h1>
        <form method="POST" action="{{ route('specialties.update', $specialty) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="text" name="name" class="form-control" value="{{ $specialty->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phí</label>
                <input type="number" name="fee" class="form-control" value="{{ $specialty->fee }}">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('specialties.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>
</html>