<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Quản lý bác sĩ
        </h2>
    </x-slot>

    <div class="container mt-5">
        <a href="{{ route('doctors.create') }}" class="btn btn-primary mb-3">Thêm bác sĩ</a>
        <form method="GET" action="{{ route('doctors.index') }}" class="mb-3">
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
                    <th>Tên</th>
                    <th>Ngày sinh</th>
                    <th>Số BHYT</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctors as $doctor)
                    <tr>
                        <td>{{ $doctor->id }}</td>
                        <td>{{ $doctor->name }}</td>
                        <td>{{ $doctor->date_of_birth }}</td>
                        <td>{{ $doctor->bhyt_number }}</td>
                        <td>
                            <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('doctors.destroy', $doctor) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Xóa bác sĩ này?')">Xóa</button>
                            </form>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-doctor-id="{{ $doctor->id }}">
                                Chọn
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $doctors->links() }}
    </div>
</x-app-layout>
