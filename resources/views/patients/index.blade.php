<!DOCTYPE html>
<html>
<head>
    <title>Quản lý bệnh nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Quản lý bệnh nhân</h1>
        <a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Thêm bệnh nhân</a>
        <form method="GET" action="{{ route('patients.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm theo tên hoặc số BHYT" value="{{ $search }}">
                <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
            </div>
        </form>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Ngày sinh</th>
                    <th>Số BHYT</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->date_of_birth }}</td>
                        <td>{{ $patient->bhyt_number }}</td>
                        <td>
                            <a href="{{ route('patients.show', $patient) }}" class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('patients.destroy', $patient) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa bệnh nhân này?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $patients->links() }}
    </div>
</body>
</html>