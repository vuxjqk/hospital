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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Thông tin chi tiết yêu cầu -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin chi tiết yêu cầu dịch vụ</h3>
                        <div class="card-tools">
                            <a href="{{ route('service-request-details.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">ID:</th>
                                        <td>{{ $serviceRequestDetail->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dịch vụ:</th>
                                        <td>{{ $serviceRequestDetail->service->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Yêu cầu dịch vụ:</th>
                                        <td>{{ $serviceRequestDetail->serviceRequest->title ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ghi chú:</th>
                                        <td>{{ $serviceRequestDetail->note ?? 'Không có ghi chú' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Ngày tạo:</th>
                                        <td>{{ $serviceRequestDetail->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cập nhật lần cuối:</th>
                                        <td>{{ $serviceRequestDetail->updated_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái:</th>
                                        <td>
                                            @if ($serviceRequestDetail->serviceResults->count() > 0)
                                                <span class="badge badge-success">Đã có kết quả</span>
                                            @else
                                                <span class="badge badge-warning">Chưa có kết quả</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Số kết quả:</th>
                                        <td>{{ $serviceRequestDetail->serviceResults->count() }} kết quả</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danh sách kết quả dịch vụ -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách kết quả dịch vụ</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#resultModal" data-detail-id="{{ $serviceRequestDetail->id }}"
                                data-service-name="{{ $serviceRequestDetail->service->name ?? 'N/A' }}">
                                <i class="fas fa-plus"></i> Thêm kết quả mới
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($serviceRequestDetail->serviceResults->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Kết quả</th>
                                            <th>File đính kèm</th>
                                            <th>Ngày kết quả</th>
                                            <th>Người tạo</th>
                                            <th>Ngày tạo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($serviceRequestDetail->serviceResults as $result)
                                            <tr>
                                                <td>{{ $result->id }}</td>
                                                <td>
                                                    @if ($result->result)
                                                        <div class="text-truncate" style="max-width: 200px;"
                                                            title="{{ $result->result }}">
                                                            {{ $result->result }}
                                                        </div>
                                                    @else
                                                        <em class="text-muted">Không có mô tả</em>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($result->result_file)
                                                        <a href="{{ $result->result_file_url }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-download"></i>
                                                            {{ $result->result_file_name }}
                                                        </a>
                                                    @else
                                                        <em class="text-muted">Không có file</em>
                                                    @endif
                                                </td>
                                                <td>{{ $result->result_date->format('d/m/Y') }}</td>
                                                <td>{{ $result->createdBy->name ?? 'N/A' }}</td>
                                                <td>{{ $result->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Chưa có kết quả nào được nhập</p>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#resultModal" data-detail-id="{{ $serviceRequestDetail->id }}"
                                    data-service-name="{{ $serviceRequestDetail->service->name ?? 'N/A' }}">
                                    <i class="fas fa-plus"></i> Nhập kết quả đầu tiên
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal nhập kết quả (tái sử dụng từ index) -->
    <div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultModalLabel">Nhập kết quả dịch vụ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="resultForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="service_request_details_id" name="service_request_details_id">

                        <div class="form-group">
                            <label for="service_name">Dịch vụ:</label>
                            <input type="text" class="form-control" id="service_name" readonly>
                        </div>

                        <div class="form-group">
                            <label for="result">Kết quả dịch vụ:</label>
                            <textarea class="form-control" id="result" name="result" rows="4" placeholder="Nhập kết quả dịch vụ..."></textarea>
                        </div>

                        <div class="form-group">
                            <label for="result_file">File kết quả (tùy chọn):</label>
                            <input type="file" class="form-control-file" id="result_file" name="result_file"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">Hỗ trợ: PDF, DOC, DOCX, JPG, JPEG, PNG (tối đa
                                10MB)</small>
                        </div>

                        <div class="form-group">
                            <label for="result_date">Ngày kết quả: <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="result_date" name="result_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu kết quả</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Xử lý khi mở modal
            $('#resultModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var detailId = button.data('detail-id');
                var serviceName = button.data('service-name');

                var modal = $(this);
                modal.find('#service_request_details_id').val(detailId);
                modal.find('#service_name').val(serviceName);
                modal.find('#result_date').val(new Date().toISOString().split('T')[0]);
            });

            // Xử lý submit form
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

            // Reset form khi đóng modal
            $('#resultModal').on('hidden.bs.modal', function() {
                $('#resultForm')[0].reset();
            });
        });
    </script>
</body>

</html>
