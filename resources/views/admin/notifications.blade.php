@extends('adminlte::page')

@section('title', 'Manajemen Notifikasi')

@section('content_header')
<h1 class="m-0 text-dark">Manajemen Notifikasi</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <button class="btn btn-primary mb-3" onclick="createNotification()">
            <i class="fas fa-plus"></i> Tambah Notifikasi
        </button>

        <div class="table-responsive">
            <table id="notifications-table" class="table table-bordered table-striped">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Judul Notifikasi</th>
                        <th>Pesan Notifikasi</th>
                        <th>Tanggal</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($notifications as $i => $n)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $n->judul_notifikasi }}</td>
                        <td>{{ Str::limit($n->pesan_notifikasi, 80) }}</td>
                        <td class="text-center">{{ $n->created_at }}</td>
                        <td class="text-center">

                            <button class="btn btn-info btn-sm btnView"
                                data-judul="{{ $n->judul_notifikasi }}"
                                data-pesan="{{ $n->pesan_notifikasi }}"
                                data-tanggal="{{ $n->created_at }}">
                                <i class="fas fa-eye"></i>
                            </button>

                            <button class="btn btn-warning btn-sm btnEdit"
                                data-id="{{ $n->id_notifikasi }}"
                                data-judul="{{ $n->judul_notifikasi }}"
                                data-pesan="{{ $n->pesan_notifikasi }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button class="btn btn-danger btn-sm btnDelete"
                                data-id="{{ $n->id_notifikasi }}">
                                <i class="fas fa-trash"></i>
                            </button>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- ================= MODAL VIEW ================= --}}
<div class="modal fade" id="modalView">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5>Detail Notifikasi</h5>
            </div>
            <div class="modal-body">
                <p><b>Judul:</b> <span id="viewJudul"></span></p>
                <p><b>Pesan:</b></p>
                <p id="viewPesan"></p>
                <p><b>Tanggal:</b> <span id="viewTanggal"></span></p>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL CREATE / EDIT ================= --}}
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <form id="formEdit">
            @csrf
            <input type="hidden" id="editId">
            <div id="methodField"></div>

            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 id="modalTitle">Tambah Notifikasi</h5>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Judul Notifikasi</label>
                        <input type="text" id="editJudul" name="judul_notifikasi" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Pesan Notifikasi</label>
                        <textarea id="editPesan" name="pesan_notifikasi" class="form-control" rows="4" required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
$(function(){
    $('#notifications-table').DataTable();

    // VIEW
    $('.btnView').click(function(){
        $('#viewJudul').text($(this).data('judul'));
        $('#viewPesan').text($(this).data('pesan'));
        $('#viewTanggal').text($(this).data('tanggal'));
        $('#modalView').modal('show');
    });

    // EDIT
    $('.btnEdit').click(function(){
        $('#editId').val($(this).data('id'));
        $('#editJudul').val($(this).data('judul'));
        $('#editPesan').val($(this).data('pesan'));
        $('#modalTitle').text('Edit Notifikasi');
        $('#methodField').html('@method("PUT")');
        $('#formEdit').attr('action', '/admin/notifications/' + $(this).data('id'));
        $('#modalEdit').modal('show');
    });

    // DELETE
    $('.btnDelete').click(function(){
        if(!confirm('Hapus notifikasi ini?')) return;
        let id = $(this).data('id');

        $.ajax({
            url: '/admin/notifications/' + id,
            method: 'POST',
            data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}'
            },
            success: function(){
                location.reload();
            }
        });
    });
});

// CREATE
function createNotification(){
    $('#editId').val('');
    $('#editJudul').val('');
    $('#editPesan').val('');
    $('#modalTitle').text('Tambah Notifikasi');
    $('#methodField').html('');
    $('#formEdit').attr('action', '{{ route("admin.notifications.store") }}');
    $('#modalEdit').modal('show');
}

// SUBMIT
$('#formEdit').submit(function(e){
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(){
            location.reload();
        }
    });
});
</script>
@stop
