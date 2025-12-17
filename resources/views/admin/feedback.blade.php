@extends('adminlte::page')

@section('title', 'Manajemen Feedback')

@section('content_header')
<h1 class="m-0 text-dark">Manajemen Feedback</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table id="feedback-table" class="table table-bordered table-striped table-hover">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Kategori Masukan</th>
                        <th>Pesan Masukan</th>
                        <th>Tanggal</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($feedbackData as $fb)
                    <tr>
                        <td class="text-center">{{ $fb->id_feedback }}</td>
                        <td>{{ $fb->kategori_masukan }}</td>
                        <td>{{ Str::limit($fb->pesan_masukan, 50) }}</td>
                        <td class="text-center">{{ $fb->tgl_masukan }}</td>
                        <td class="text-center">

                            <button class="btn btn-info btn-sm btnView"
                                data-kategori="{{ $fb->kategori_masukan }}"
                                data-pesan="{{ $fb->pesan_masukan }}"
                                data-tanggal="{{ $fb->tgl_masukan }}">
                                <i class="fas fa-eye"></i>
                            </button>

                            <button class="btn btn-warning btn-sm btnEdit"
                                data-id="{{ $fb->id_feedback }}"
                                data-kategori="{{ $fb->kategori_masukan }}"
                                data-pesan="{{ $fb->pesan_masukan }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button class="btn btn-danger btn-sm btnDelete"
                                data-id="{{ $fb->id_feedback }}">
                                <i class="fas fa-trash"></i>
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
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
                <h5>Detail Feedback</h5>
            </div>
            <div class="modal-body">
                <p><b>Kategori Masukan:</b> <span id="viewKategori"></span></p>
                <p><b>Pesan Masukan:</b></p>
                <p id="viewPesan"></p>
                <p><b>Tanggal:</b> <span id="viewTanggal"></span></p>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL EDIT ================= --}}
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <form id="formEdit">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5>Edit Feedback</h5>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="editId">

                    <div class="form-group">
                        <label>Kategori Masukan</label>
                        <input type="text" id="editKategori" name="kategori_masukan" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Pesan Masukan</label>
                        <textarea id="editPesan" name="pesan_masukan" class="form-control"></textarea>
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

    // VIEW
    $('.btnView').click(function(){
        $('#viewKategori').text($(this).data('kategori'));
        $('#viewPesan').text($(this).data('pesan'));
        $('#viewTanggal').text($(this).data('tanggal'));
        $('#modalView').modal('show');
    });

    // EDIT
    $('.btnEdit').click(function(){
        $('#editId').val($(this).data('id'));
        $('#editKategori').val($(this).data('kategori'));
        $('#editPesan').val($(this).data('pesan'));
        $('#modalEdit').modal('show');
    });

    // UPDATE
    $('#formEdit').submit(function(e){
        e.preventDefault();
        let id = $('#editId').val();

        $.ajax({
            url: '/admin/feedback/' + id,
            method: 'POST',
            data: $(this).serialize(),
            success: function(){
                location.reload();
            }
        });
    });

    // DELETE
    $('.btnDelete').click(function(){
        if(!confirm('Hapus feedback?')) return;
        let id = $(this).data('id');

        $.ajax({
            url: '/admin/feedback/' + id,
            method: 'POST',
            data: {_method:'DELETE', _token:'{{ csrf_token() }}'},
            success: function(){
                location.reload();
            }
        });
    });

});
</script>
@stop
