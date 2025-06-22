<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Quản lý hồ sơ bệnh án
        </h2>
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-4">
                <div class="list-group">
                    <li class="list-group-item active">DANH SÁCH BỆNH NHÂN</li>
                    <li class="list-group-item mb-3">
                        <form method="GET" action="{{ route('medical_records.index') }}">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm..."
                                    value="{{ $search }}">
                                <button class="btn btn-outline-secondary" type="submit">Tìm</button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    Thêm
                                </button>
                            </div>
                        </form>
                    </li>
                    @foreach ($patients as $patient)
                        <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" data-patient-id="{{ $patient->id }}"
                            data-patient-name="{{ $patient->name }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $patient->name }}</h5>
                                <small class="text-body-secondary">3 days ago</small>
                            </div>
                            <p class="mb-1">Số CCCD: {{ $patient->national_id }}</p>
                            <small class="text-body-secondary">Số BHYT: {{ $patient->insurance_number }}</small>
                        </button>
                    @endforeach
                </div>
            </div>
            {{ $patients->links() }}

            <div class="col-8">
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

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('medical_records.store') }}">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="selectedName">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <input type="hidden" name="patient_id" id="selectedId">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="switchCheckDefault" value="inpatient" name="type">
                                        <label class="form-check-label" for="switchCheckDefault">Nhập viện</label>
                                    </div>
                                </div>

                                <div class="mb-3" id="specialtySelectWrapper">
                                    <select class="form-select" aria-label="Default select example" name="specialty_id"
                                        required>
                                        <option value="">--- Chọn chuyên khoa ---</option>
                                        @foreach ($specialties as $specialty)
                                            <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="checkDefault"
                                        name="has_insurance">
                                    <label class="form-check-label" for="checkDefault">
                                        Có bảo hiểm y tế?
                                    </label>
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
        </div>
    </div>

    <form method="POST" action="{{ route('patients.store') }}">
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm bệnh nhân</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        const exampleModal = document.getElementById('exampleModal');
        exampleModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const name = button.getAttribute('data-patient-name');
            const id = button.getAttribute('data-patient-id');

            const namePlaceholder = exampleModal.querySelector('#selectedName');
            namePlaceholder.textContent = name;

            const idPlaceholder = exampleModal.querySelector('#selectedId');
            idPlaceholder.value = id;
        });

        document.addEventListener('DOMContentLoaded', function() {
            const switchCheck = document.getElementById('switchCheckDefault');
            const specialtyWrapper = document.getElementById('specialtySelectWrapper');
            const specialtySelect = specialtyWrapper.querySelector('select[name="specialty_id"]');

            function toggleSpecialtySelect() {
                if (switchCheck.checked) {
                    specialtyWrapper.style.display = 'none';
                    specialtySelect.removeAttribute('required');
                } else {
                    specialtyWrapper.style.display = 'block';
                    specialtySelect.setAttribute('required', 'required');
                }
            }

            toggleSpecialtySelect();
            switchCheck.addEventListener('change', toggleSpecialtySelect);
        });
    </script>
</x-app-layout>
