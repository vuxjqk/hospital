<!DOCTYPE html>
<html>
<head>
    <title>Sửa bệnh nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Sửa bệnh nhân</h1>
        <form method="POST" action="{{ route('patients.update', $patient) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Số CCCD</label>
                <input type="text" name="national_id" class="form-control" value="{{ $patient->national_id }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="text" name="name" class="form-control" value="{{ $patient->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ngày sinh</label>
                <input type="date" name="date_of_birth" class="form-control" value="{{ $patient->date_of_birth }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Giới tính</label>
                <select name="gender" class="form-control">
                    <option value="">Chọn</option>
                    <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>Nam</option>
                    <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                    <option value="other" {{ $patient->gender == 'other' ? 'selected' : '' }}>Khác</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="address" class="form-control" value="{{ $patient->address }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Số BHYT</label>
                <input type="text" name="insurance_number" class="form-control" value="{{ $patient->insurance_number }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Ngày hết hạn BHYT</label>
                <input type="date" name="insurance_expiry_date" class="form-control" value="{{ $patient->insurance_expiry_date }}">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>
</html>