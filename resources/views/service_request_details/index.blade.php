<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chi tiết yêu cầu dịch vụ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .table thead th {
            background-color: #f8f9fa;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f1f3f5;
        }

        .btn-sm {
            margin-right: 0.5rem;
        }

        .badge {
            font-size: 0.85em;
            padding: 0.5em 1em;
        }

        .navbar-brand {
            font-weight: 600;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .modal-header {
            background-color: #f8f9fa;
        }

        .form-control-file {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Quản lý dịch vụ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="false" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Danh sách yêu cầu</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Chi tiết yêu cầu dịch vụ</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Dịch vụ</th>
                                        <th>Yêu cầu dịch vụ</th>
                                        <th>Ghi chú</th>
                                        <th>Ngày tạo</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($serviceRequestDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->id }}</td>
                                            <td>{{ $detail->service->name ?? 'N/A' }}</td>
                                            <td>{{ $detail->serviceRequest->title ?? 'N/A' }}</td>
                                            <td>{{ $detail->note ?? 'Không có ghi chú' }}</td>
                                            <td>{{ $detail->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if ($detail->service_result != null)
                                                    <span class="badge bg-success">Đã có kết quả</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Chưa có kết quả</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#resultModal"
                                                    data-detail-id="{{ $detail->id }}"
                                                    data-service-name="{{ $detail->service->name ?? 'N/A' }}">
                                                    <i class="fas fa-plus"></i> Nhập kết quả
                                                </button>
                                                <a href="{{ route('service-request-details.show', $detail->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $serviceRequestDetails->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultModalLabel">Nhập kết quả dịch vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="resultForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="service_request_details_id" name="service_request_details_id">
                        <div class="mb-3">
                            <label for="service_name" class="form-label">Dịch vụ:</label>
                            <input type="text" class="form-control" id="service_name" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="result" class="form-label">Kết quả dịch vụ:</label>
                            <textarea class="form-control" id="result" name="result" rows="4" placeholder="Nhập kết quả dịch vụ..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="result_file" class="form-label">File kết quả (tùy chọn):</label>
                            <input type="file" class="form-control" id="result_file" name="result_file"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <div class="form-text">Hỗ trợ: PDF, DOC, DOCX, JPG, JPEG, PNG (tối đa 10MB)</div>
                        </div>
                        <div class="mb-3">
                            <label for="result_date" class="form-label">Ngày kết quả: <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="result_date" name="result_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu kết quả</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#resultModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var detailId = button.data('detail-id');
                var serviceName = button.data('service-name');
                var modal = $(this);
                modal.find('#service_request_details_id').val(detailId);
                modal.find('#service_name').val(serviceName);
                modal.find('#result_date').val(new Date().toISOString().split('T')[0]);
            });

            $('#resultForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('service-request-details.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#resultModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Có lỗi xảy ra:\n';
                        if (errors) {
                            $.each(errors, function(key, value) {
                                errorMessage += '- ' + value[0] + '\n';
                            });
                        } else {
                            errorMessage += 'Lỗi không xác định.';
                        }
                        alert(errorMessage);
                    }
                });
            });

            $('#resultModal').on('hidden.bs.modal', function() {
                $('#resultForm')[0].reset();
            });
        });
    </script>
</body>

</html>
