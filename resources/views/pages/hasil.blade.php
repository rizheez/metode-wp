@extends('layouts.main')
@section('title', 'Metode WP')

@section('main')
    <div>
        <table class="table">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <!-- Button trigger modal -->


            <thead>
                <tr>

                    <th scope="col">Nama Alternatif</th>
                    <th scope="col">Ranking</th>
                    <th scope="col">Vektor V</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>

                        <td>{{ $d->nama_alternatif }}</td>
                        <td>{{ $d->ranking }}</td>
                        <td>{{ round($d->V, 4) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


@endsection
