@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Pesanan Saya</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan as $p)
            <tr>
                <td>{{ $p->created_at->format('d M Y') }}</td>
                <td>Rp {{ number_format($p->total_harga) }}</td>
                <td>
                    <span class="badge {{ $p->status == 'pending' ? 'bg-warning' : ($p->status == 'lunas' ? 'bg-success' : 'bg-secondary') }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection