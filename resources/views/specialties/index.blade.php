<!DOCTYPE html>
<html>

<head>
    <title>Quản lý chuyên khoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Quản lý chuyên khoa</h1>
        <a href="{{ route('specialties.create') }}" class="btn btn-primary mb-3">Thêm chuyên khoa</a>
        <form method="GET" action="{{ route('specialties.index') }}" class="mb-3">
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
                    <th>Phí</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($specialties as $specialty)
                    <tr>
                        <td>{{ $specialty->id }}</td>
                        <td>{{ $specialty->name }}</td>
                        <td>{{ $specialty->fee }}</td>
                        <td>
                            <a href="{{ route('specialties.show', $specialty) }}" class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('specialties.edit', $specialty) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('specialties.destroy', $specialty) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Xóa chuyên khoa này?')">Xóa</button>
                            </form>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-specialty-id="{{ $specialty->id }}">
                                Chọn
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $specialties->links() }}
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('medical_records.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="specialty_id" id="modalspecialtyId">
                        <div class="mb-3">
                            <select class="form-select" aria-label="Default select example" name="type">
                                <option value="outspecialty">Ngoại trú</option>
                                <option value="inspecialty">Nội trú</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkDefault"
                                    name="has_insurance" value="1">
                                <label class="form-check-label" for="checkDefault">
                                    Có bảo hiểm y tế?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('exampleModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const specialtyId = button.getAttribute('data-specialty-id');
            document.getElementById('modalspecialtyId').value = specialtyId;
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>
