@extends('adminlte::page')

@section('title', 'Manajemen Feedback')

@section('content_header')
    <h1 class="m-0 text-dark">Manajemen Feedback</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="table-responsive">
            <table id="feedback-table" class="table table-bordered table-striped table-hover" style="width:100%">
                <thead class="thead-light text-center">
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th>Nama</th>
                        <th>Judul Masukan</th>
                        <th>Pesan Masukan</th>
                        <th style="width: 15%">Tanggal</th>
                        <th style="width: 10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($feedbackData as $fb)
                    <tr>
                        <td class="text-center">{{ $fb->id }}</td>
                        <td>{{ $fb->name }}</td>
                        <td>{{ $fb->judul }}</td>
                        <td>{{ Str::limit($fb->pesan, 50, '...') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($fb->created_at)->format('d M Y, H:i') }}</td>

                        <!-- Aksi -->
                        <td class="text-center">
                            <button class="btn btn-info btn-sm btnView" 
                                data-id="{{ $fb->id }}"
                                data-nama="{{ $fb->name }}"
                                data-judul="{{ $fb->judul }}"
                                data-pesan="{{ $fb->pesan }}"
                                data-tanggal="{{ \Carbon\Carbon::parse($fb->created_at)->format('d M Y, H:i') }}">
                                <i class="fas fa-eye"></i>
                            </button>

                            <button class="btn btn-warning btn-sm btnEdit"
                                data-id="{{ $fb->id }}"
                                data-nama="{{ $fb->name }}"
                                data-judul="{{ $fb->judul }}"
                                data-pesan="{{ $fb->pesan }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button class="btn btn-danger btn-sm btnDelete"
                                data-id="{{ $fb->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data feedback.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- MODAL VIEW DETAIL --}}
<div class="modal fade" id="modalView" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detail Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="viewId"></span></p>
                <p><strong>Nama:</strong> <span id="viewNama"></span></p>
                <p><strong>Judul:</strong> <span id="viewJudul"></span></p>
                <p><strong>Pesan:</strong></p>
                <div class="border p-2 rounded">
                    <p id="viewPesan"></p>
                </div>
                <p class="mt-2"><strong>Tanggal:</strong> <span id="viewTanggal"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="POST" id="formEdit">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Edit Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
                    
                    <div class="form-group">
                        <label for="editNama">Nama User</label>
                        <input type="text" id="editNama" name="nama_user" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editJudul">Judul</label>
                        <input type="text" id="editJudul" name="judul" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editPesan">Pesan</label>
                        <textarea id="editPesan" name="pesan" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@stop

@section('js')
<script>
$(document).ready(function(){
    // CSRF Token setup untuk AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // VIEW DETAIL
    $(document).on('click', '.btnView', function(){
        $("#viewId").text($(this).data("id"));
        $("#viewNama").text($(this).data("nama"));
        $("#viewJudul").text($(this).data("judul"));
        $("#viewPesan").text($(this).data("pesan"));
        $("#viewTanggal").text($(this).data("tanggal"));
        $("#modalView").modal("show");
    });

    // EDIT
    $(document).on('click', '.btnEdit', function(){
        let id = $(this).data("id");
        
        $("#editId").val(id);
        $("#editNama").val($(this).data("nama"));
        $("#editJudul").val($(this).data("judul"));
        $("#editPesan").val($(this).data("pesan"));
        
        // Set form action
        $("#formEdit").attr("action", "/admin/feedback/" + id);
        $("#modalEdit").modal("show");
    });

    // Handle form submit untuk edit
    $("#formEdit").submit(function(e){
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response){
                $("#modalEdit").modal("hide");
                alert(response.message);
                location.reload();
            },
            error: function(xhr){
                alert('Terjadi kesalahan saat menyimpan data.');
                console.error(xhr.responseText);
            }
        });
    });

    // DELETE
    $(document).on('click', '.btnDelete', function(){
        let id = $(this).data("id");
        let row = $(this).closest('tr');
        
        if(confirm("Yakin ingin menghapus feedback ini?")){
            $.ajax({
                url: "/admin/feedback/" + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    if(response.success){
                        row.fadeOut(300, function(){
                            $(this).remove();
                        });
                        alert(response.message);
                    }
                },
                error: function(xhr){
                    alert('Terjadi kesalahan saat menghapus data.');
                    console.error(xhr.responseText);
                }
            });
        }
    });
});
</script>
@stop