<!DOCTYPE html>
<html>

<head>
    <title>Quản lý hồ sơ bệnh án</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Quản lý hồ sơ bệnh án</h1>
        {{-- <a href="{{ route('medical_records.create') }}" class="btn btn-primary mb-3">Thêm hồ sơ bệnh án</a> --}}
        <form method="GET" action="{{ route('medical_records.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm theo tên hoặc số BHYT"
                    value="{{ $search }}">
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
                    <th>Số CCCD</th>
                    <th>Tên</th>
                    <th>Loại</th>
                    <th>Có BHYT</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medical_records as $medical_record)
                    <tr>
                        <td>{{ $medical_record->id }}</td>
                        <td>{{ $medical_record->patient->national_id }}</td>
                        <td>{{ $medical_record->patient->name }}</td>
                        <td>{{ $medical_record->type }}</td>
                        <td>{{ $medical_record->has_insurance }}</td>
                        <td>
                            {{-- <a href="{{ route('medical_records.show', $medical_record) }}"
                                class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('medical_records.edit', $medical_record) }}"
                                class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('medical_records.destroy', $medical_record) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Xóa hồ sơ bệnh án này?')">Xóa</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $medical_records->links() }}
    </div>
</body>

</html>
