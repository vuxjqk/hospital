<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Quản lý lịch khám
        </h2>
    </x-slot>

    <div class="container mt-5">
        <form method="GET" action="{{ route('appointments.index') }}" class="mb-3">
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
                    <th>STT</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->patient->name }}</td>
                        <td>{{ $appointment->queue_number }}</td>
                        <td>{{ $appointment->status }}</td>
                        <td>
                            {{-- <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('appointments.edit', $appointment) }}"
                                class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('appointments.destroy', $appointment) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Xóa lịch khám này?')">Xóa</button>
                            </form> --}}
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-appointment-id="{{ $appointment->id }}">
                                Khám
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $appointments->links() }}
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="appointmentForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Khám bệnh</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="appointment_id" id="modalAppointmentId">
                        <div class="mb-3">
                            <label class="form-label">Triệu chứng</label>
                            <input type="text" name="symptoms" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Chẩn đoán</label>
                            <input type="text" name="diagnosis" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lưu ý</label>
                            <input type="text" name="note" class="form-control">
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
        const modal = document.getElementById('exampleModal');
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-appointment-id');
            const form = document.getElementById('appointmentForm');

            // Đúng route RESTful: /appointments/{id}
            form.action = `{{ route('appointments.update', ':id') }}`.replace(':id', id);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</x-app-layout>
