<!DOCTYPE html>
<html>
<head>
    <title>Thêm bệnh nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Thêm bệnh nhân</h1>
        <form method="POST" action="{{ route('patients.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Số CCCD</label>
                <input type="text" name="national_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ngày sinh</label>
                <input type="date" name="date_of_birth" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Giới tính</label>
                <select name="gender" class="form-control">
                    <option value="">Chọn</option>
                    <option value="male">Nam</option>
                    <option value="female">Nữ</option>
                    <option value="other">Khác</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="address" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Số BHYT</label>
                <input type="text" name="insurance_number" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Ngày hết hạn BHYT</label>
                <input type="date" name="insurance_expiry_date" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>
</html>