@extends('adminlte::page')

@section('title', 'Manajemen Reservasi Tempat')

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
                        <th>Nama Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Jumlah Orang</th>
                        <th>Status</th>
                        <th width="130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $index => $reservation)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $reservation->name }}</td>
                            <td>{{ $reservation->date }}</td>
                            <td>{{ $reservation->time }}</td>
                            <td>{{ $reservation->people }}</td>
                            <td>
                                @if ($reservation->status == 'Confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif ($reservation->status == 'Pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                @endif
                            </td>
                            <td>
                                <button onclick="viewReservation({{ $reservation->id }})" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="editReservation({{ $reservation->id }})" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteReservation({{ $reservation->id }})" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- modal view --}}
    <div class="modal fade" id="viewModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title">Detail Reservasi</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">
                    <p><b>Nama:</b> <span id="viewName"></span></p>
                    <p><b>Tanggal:</b> <span id="viewDate"></span></p>
                    <p><b>Waktu:</b> <span id="viewTime"></span></p>
                    <p><b>Jumlah Orang:</b> <span id="viewPeople"></span></p>
                    <p><b>Status:</b> <span id="viewStatus"></span></p>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal edit --}}
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Edit Reservasi</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <form id="formEdit">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id">

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" id="editName" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" id="editDate" name="date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Waktu</label>
                            <input type="time" id="editTime" name="time" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Jumlah Orang</label>
                            <input type="number" id="editPeople" name="people" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select id="editStatus" name="status" class="form-control">
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop

@section('js')
<script>
    $(function () {
        $('#reservationsTable').DataTable();
    });

    // VIEW
    function viewReservation(id) {
        $.get('/admin/reservations/' + id, function (data) {
            $('#viewName').text(data.name);
            $('#viewDate').text(data.date);
            $('#viewTime').text(data.time);
            $('#viewPeople').text(data.people);
            $('#viewStatus').text(data.status);

            $('#viewModal').modal('show');
        });
    }

    // EDIT
    function editReservation(id) {
        $.get('/admin/reservations/' + id, function (data) {
            $('#editId').val(data.id);
            $('#editName').val(data.name);
            $('#editDate').val(data.date);
            $('#editTime').val(data.time);
            $('#editPeople').val(data.people);
            $('#editStatus').val(data.status);

            $('#editModal').modal('show');
        });
    }

    // UPDATE
    $('#formEdit').submit(function (e) {
        e.preventDefault();

        let id = $('#editId').val();

        $.ajax({
            url: '/admin/reservations/' + id,
            method: 'POST',
            data: $('#formEdit').serialize() + '&_method=PUT',
            success: function () {
                $('#editModal').modal('hide');
                location.reload();
            }
        });
    });

    // DELETE
    function deleteReservation(id) {
        if (!confirm('Yakin ingin menghapus data ini?')) return;

        $.ajax({
            url: '/admin/reservations/' + id,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function () {
                location.reload();
            }
        });
    }
</script>
@stop
