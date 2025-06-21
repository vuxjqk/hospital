<!DOCTYPE html>
<html>
<head>
    <title>Chi tiết bệnh nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Chi tiết bệnh nhân</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>ID:</strong> {{ $patient->id }}</p>
                <p><strong>Số CCCD:</strong> {{ $patient->national_id }}</p>
                <p><strong>Tên:</strong> {{ $patient->name }}</p>
                <p><strong>Ngày sinh:</strong> {{ $patient->date_of_birth }}</p>
                <p><strong>Giới tính:</strong> {{ $patient->gender === 'male' ? 'Nam' : ($patient->gender === 'female' ? 'Nữ' : 'Khác') }}</p>
                <p><strong>Địa chỉ:</strong> {{ $patient->address }}</p>
                <p><strong>Số BHYT:</strong> {{ $patient->insurance_number }}</p>
                <p><strong>Ngày hết hạn BHYT:</strong> {{ $patient->insurance_expiry_date }}</p>
            </div>
        </div>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
    </div>
</body>
</html>