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
                    <th scope="col">NO</th>
                    <th scope="col">Nama Alternatif</th>
                    <th scope="col">Vektor S</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($vektorS as $alternatif => $nilaiS)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alternatif }}</td>
                        <td>{{ round($nilaiS, 4) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5">
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
                    <th scope="col">NO</th>
                    <th scope="col">Nama Alternatif</th>
                    <th scope="col">Vektor V</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($preferensi as $alternatif => $nilaiV)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alternatif }}</td>
                        <td>{{ $nilaiV }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
