@extends('adminlte::page')

@section('title', 'Manajemen Notifikasi')

@section('content_header')
    <h1 class="m-0 text-dark">Manajemen Notifikasi</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        {{-- Notifikasi Sukses/Error --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Tombol Tambah --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <button onclick="createNotification()" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Notifikasi Baru
                </button>
            </div>
        </div>

        {{-- Tabel Notifikasi --}}
        <div class="table-responsive">
            <table id="notifications-table" class="table table-bordered table-striped table-hover" style="width:100%">
                <thead class="thead-light text-center">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 25%;">Judul</th>
                        <th style="width: 40%;">Pesan</th>
                        <th style="width: 10%;">Tanggal Dibuat</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notifications as $key => $notification)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>
                                @if($notification->title)
                                    {{ $notification->title }}
                                @else
                                    <span class="text-muted font-italic">(Tidak ada judul)</span>
                                @endif
                            </td>
                            <td>
                                <div class="message-preview">
                                    {{ Str::limit($notification->message, 100, '...') }}
                                </div>
                                @if(strlen($notification->message) > 100)
                                    <button class="btn btn-sm btn-link view-more" data-message="{{ $notification->message }}">
                                        Lihat Selengkapnya
                                    </button>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button onclick="viewNotification({{ $notification->id }})" class="btn btn-info btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="editNotification({{ $notification->id }})" class="btn btn-primary btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteNotification({{ $notification->id }})" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <br>
                                Tidak ada data notifikasi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Lihat Pesan Lengkap -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Pesan Lengkap</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="full-message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Detail -->
<div class="modal fade" id="viewModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Detail Notifikasi</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p><b>Judul:</b> <span id="viewTitle"></span></p>
                <p><b>Pesan:</b> <span id="viewMessage"></span></p>
                <p><b>Tanggal Dibuat:</b> <span id="viewCreatedAt"></span></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create & Edit -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="editModalTitle">Tambah Notifikasi Baru</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <form id="formEdit" action="{{ route('admin.notifications.store') }}">
                @csrf
                <div id="method-field"></div>

                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">

                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" id="editTitle" name="title" class="form-control" placeholder="Masukkan judul notifikasi" required>
                    </div>

                    <div class="form-group">
                        <label>Pesan <span class="text-danger">*</span></label>
                        <textarea id="editMessage" name="message" class="form-control" rows="5" placeholder="Masukkan pesan notifikasi" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .message-preview {
            display: inline;
        }
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
        .btn-group .btn {
            margin-right: 2px;
        }
        .badge {
            font-size: 0.85em;
        }
    </style>
@stop

@section('js')
<script>
    $(function () {
        $('#notifications-table').DataTable();
        
        // Event handler untuk lihat selengkapnya pesan
        $(document).on('click', '.view-more', function() {
            var message = $(this).data('message');
            $('#full-message').text(message);
            $('#messageModal').modal('show');
        });
    });

    // CREATE
    function createNotification() {
        $('#editId').val('');
        $('#editTitle').val('');
        $('#editMessage').val('');

        $('#editModalTitle').text('Tambah Notifikasi Baru');
        $('#method-field').html(''); // tidak perlu _method untuk POST
        $('#formEdit').attr('action', '{{ route("admin.notifications.store") }}');
        $('#editModal').modal('show');
    }

    // VIEW
    function viewNotification(id) {
        $.ajax({
            url: '/admin/notifications/' + id,
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (data) {
                $('#viewTitle').text(data.title || '(Tidak ada judul)');
                $('#viewMessage').text(data.message);
                $('#viewCreatedAt').text(formatDate(data.created_at));
                $('#viewModal').modal('show');
            },
            error: function (xhr) {
                alert('Error: ' + (xhr.responseJSON?.error || 'Gagal memuat data notifikasi'));
            }
        });
    }

    // EDIT
    function editNotification(id) {
        $.ajax({
            url: '/admin/notifications/' + id,
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (data) {
                $('#editId').val(data.id);
                $('#editTitle').val(data.title);
                $('#editMessage').val(data.message);

                $('#editModalTitle').text('Edit Notifikasi');
                $('#method-field').html('@method("PUT")');
                $('#formEdit').attr('action', '/admin/notifications/' + data.id);
                $('#editModal').modal('show');
            },
            error: function (xhr) {
                alert('Error: ' + (xhr.responseJSON?.error || 'Gagal memuat data notifikasi'));
            }
        });
    }

    // SUBMIT CREATE/UPDATE
    $('#formEdit').submit(function (e) {
        e.preventDefault();

        let formData = $(this).serialize();
        let url = $(this).attr('action');
        let method = 'POST';

        $.ajax({
            url: url,
            method: method,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#editModal').modal('hide');
                location.reload();
            },
            error: function (xhr) {
                let errors = xhr.responseJSON?.errors;
                if (errors) {
                    let errorMessage = '';
                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + '\n';
                    });
                    alert('Error: ' + errorMessage);
                } else {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
                }
            }
        });
    });

    // DELETE
    function deleteNotification(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) return;

        $.ajax({
            url: '/admin/notifications/' + id,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function () {
                location.reload();
            },
            error: function (xhr) {
                alert('Error: ' + (xhr.responseJSON?.error || 'Gagal menghapus notifikasi'));
            }
        });
    }

    // Format date helper
    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        
        return `${day}/${month}/${year} ${hours}:${minutes}`;
    }
</script>
@stop