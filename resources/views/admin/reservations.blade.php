@extends('adminlte::page')

@section('title', 'Manajemen Reservasi')

@section('content_header')
<h1>Manajemen Reservasi Tempat</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table id="reservationsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>Tanggal</th>
                    <th>Jam Mulai</th>
                    <th>Jumlah Orang</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->nama_pemesan }}</td>
                    <td>{{ $r->tgl_reservasi }}</td>
                    <td>{{ $r->jam_mulai }}</td>
                    <td>{{ $r->jml_org }}</td>
                    <td>
                        <span class="badge bg-{{ 
                            $r->status_reservasi == 'pending' ? 'warning' : 
                            ($r->status_reservasi == 'diterima' ? 'primary' : 
                            ($r->status_reservasi == 'selesai' ? 'success' : 'danger')) 
                        }}">
                            {{ ucfirst($r->status_reservasi) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="editReservation({{ $r->id_reservasi }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteReservation({{ $r->id_reservasi }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Edit Reservasi</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form id="formEdit">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId">

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama Pemesan</label>
                        <input type="text" id="editNama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Reservasi</label>
                        <input type="date" id="editTanggal" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Jam Mulai</label>
                        <input type="time" id="editJamMulai" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Orang</label>
                        <input type="number" id="editJumlah" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select id="editStatus" class="form-control" required>
                            <option value="pending">Pending</option>
                            <option value="diterima">Diterima</option>
                            <option value="selesai">Selesai</option>
                            <option value="batal">Batal</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
$(document).ready(function () {
    $('#reservationsTable').DataTable();

    $('#formEdit').submit(function(e){
        e.preventDefault();

        let id = $('#editId').val();

        $.ajax({
            url: '/admin/reservations/' + id,
            type: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                nama_pemesan: $('#editNama').val(),
                tgl_reservasi: $('#editTanggal').val(),
                jam_mulai: $('#editJamMulai').val(),
                jml_org: $('#editJumlah').val(),
                status_reservasi: $('#editStatus').val()
            },
            success: function () {
                $('#editModal').modal('hide');
                alert('Data berhasil diperbarui');
                location.reload();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Gagal menyimpan data');
            }
        });
    });
});

function editReservation(id){
    $.get('/admin/reservations/' + id, function(data){
        $('#editId').val(data.id_reservasi);
        $('#editNama').val(data.nama_pemesan);
        $('#editTanggal').val(data.tgl_reservasi);
        $('#editJamMulai').val(data.jam_mulai);
        $('#editJumlah').val(data.jml_org);
        $('#editStatus').val(data.status_reservasi);
        $('#editModal').modal('show');
    });
}

function deleteReservation(id){
    if(!confirm('Yakin ingin menghapus data ini?')) return;

    $.ajax({
        url: '/admin/reservations/' + id,
        type: 'DELETE',
        data: {_token: $('meta[name="csrf-token"]').attr('content')},
        success: function(){
            location.reload();
        }
    });
}
</script>
@stop
