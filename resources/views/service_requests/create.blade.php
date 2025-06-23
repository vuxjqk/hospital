<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Tạo Yêu Cầu Dịch Vụ</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('service-requests.store') }}" method="POST" id="serviceRequestForm">
                            @csrf

                            <!-- Appointment ID (hidden) -->
                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                            <!-- Appointment Info -->
                            <div class="mb-3">
                                <label class="form-label"><strong>Thông tin cuộc hẹn:</strong></label>
                                <div class="card bg-light">
                                    <div class="card-body py-2">
                                        <small class="text-muted">
                                            Mã cuộc hẹn: #{{ $appointment->id }} -
                                            Ngày: {{ $appointment->appointment_date }} -
                                            Khách hàng: {{ $appointment->patient->name ?? 'N/A' }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả yêu cầu</label>
                                <textarea class="form-control" id="description" name="description" rows="3"
                                    placeholder="Nhập mô tả chi tiết về yêu cầu dịch vụ..." maxlength="255">{{ old('description') }}</textarea>
                                <div class="form-text">Tối đa 255 ký tự</div>
                            </div>

                            <!-- Services Section -->
                            <div class="mb-4">
                                <label class="form-label"><strong>Chọn dịch vụ <span
                                            class="text-danger">*</span></strong></label>
                                <div id="servicesContainer">
                                    <!-- Service Item Template -->
                                    <div class="service-item border rounded p-3 mb-3" data-index="0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Dịch vụ</label>
                                                <select class="form-select" name="service_id[]" required>
                                                    <option value="">-- Chọn dịch vụ --</option>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}"
                                                            {{ old('service_id.0') == $service->id ? 'selected' : '' }}>
                                                            {{ $service->name }} -
                                                            {{ number_format($service->fee) }}000đ
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">Ghi chú</label>
                                                <input type="text" class="form-control" name="note[]"
                                                    placeholder="Ghi chú cho dịch vụ này..." maxlength="255"
                                                    value="{{ old('note.0') }}">
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm remove-service"
                                                    onclick="removeService(this)" style="display: none;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addService()">
                                    <i class="fas fa-plus"></i> Thêm dịch vụ
                                </button>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Tạo yêu cầu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let serviceIndex = 1;

        function addService() {
            const container = document.getElementById('servicesContainer');
            const template = container.querySelector('.service-item').cloneNode(true);

            // Update index
            template.setAttribute('data-index', serviceIndex);

            // Clear values
            template.querySelector('select').value = '';
            template.querySelector('input').value = '';

            // Show remove button
            template.querySelector('.remove-service').style.display = 'block';

            // Update select name for old() helper
            template.querySelector('select').name = `service_id[${serviceIndex}]`;
            template.querySelector('input').name = `note[${serviceIndex}]`;

            container.appendChild(template);
            serviceIndex++;

            updateRemoveButtons();
        }

        function removeService(button) {
            const serviceItem = button.closest('.service-item');
            serviceItem.remove();
            updateRemoveButtons();
        }

        function updateRemoveButtons() {
            const serviceItems = document.querySelectorAll('.service-item');
            const removeButtons = document.querySelectorAll('.remove-service');

            if (serviceItems.length <= 1) {
                removeButtons.forEach(btn => btn.style.display = 'none');
            } else {
                removeButtons.forEach(btn => btn.style.display = 'block');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateRemoveButtons();

            // Handle old input values for multiple services
            @if (old('service_id'))
                @foreach (old('service_id') as $index => $serviceId)
                    @if ($index > 0)
                        addService();
                        document.querySelector(`select[name="service_id[{{ $index }}]"]`).value =
                            '{{ $serviceId }}';
                        document.querySelector(`input[name="note[{{ $index }}]"]`).value =
                            '{{ old("note.$index") }}';
                    @endif
                @endforeach
            @endif
        });

        // Form validation
        document.getElementById('serviceRequestForm').addEventListener('submit', function(e) {
            const services = document.querySelectorAll('select[name="service_id[]"]');
            let hasSelectedService = false;

            services.forEach(select => {
                if (select.value) {
                    hasSelectedService = true;
                }
            });

            if (!hasSelectedService) {
                e.preventDefault();
                alert('Vui lòng chọn ít nhất một dịch vụ!');
            }
        });
    </script>

    <style>
        .service-item {
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .service-item:hover {
            background-color: #e9ecef;
        }

        .remove-service {
            width: 35px;
            height: 35px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .form-label strong {
            color: #495057;
        }

        .text-danger {
            color: #dc3545 !important;
        }
    </style>
</body>

</html>
