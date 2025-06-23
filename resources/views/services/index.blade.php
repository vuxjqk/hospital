<!DOCTYPE html>
<html>

<head>
    <title>Quản lý dịch vụ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Quản lý dịch vụ</h1>
        <a href="{{ route('services.create') }}" class="btn btn-primary mb-3">Thêm dịch vụ</a>
        <form method="GET" action="{{ route('services.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm theo tên"
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
                    <th>Tên</th>
                    <th>Phí</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->fee }}</td>
                        <td>
                            <a href="{{ route('services.show', $service) }}" class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('services.destroy', $service) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Xóa dịch vụ này?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $services->links() }}
    </div>
</body>

</html>
