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
                @foreach ($patients as $patient)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->date_of_birth }}</td>
                        <td>{{ $patient->bhyt_number }}</td>
                        <td>
                            <a href="{{ route('patients.show', $patient) }}" class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('patients.destroy', $patient) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Xóa bệnh nhân này?')">Xóa</button>
                            </form>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-patient-id="{{ $patient->id }}">
                                Chọn
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $patients->links() }}
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
                        <input type="hidden" name="patient_id" id="modalPatientId">
                        <div class="mb-3">
                            <select class="form-select" aria-label="Default select example" name="type">
                                <option value="outpatient">Ngoại trú</option>
                                <option value="inpatient">Nội trú</option>
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
            const patientId = button.getAttribute('data-patient-id');
            document.getElementById('modalPatientId').value = patientId;
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>
