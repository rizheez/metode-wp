@extends('layouts.main')

@section('title', 'data')

@section('main')
    <div>
        <form action="{{ route('dataal') }}" method="POST">
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
                @csrf
                <thead>
                    <tr>
                        <th scope="col">Nama Alternatif</th>
                        @foreach ($kriteria as $item)
                            <th>{{ $item }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alternatif as $d)
                        <tr>
                            <td>{{ $d }}</td>
                            @foreach ($kriteria as $item)
                                <td><input type="text" name="nilai[{{ $d }}][{{ $item }}]"
                                        style="width: 50px;"></td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>

        @if ($dataal !== null)

            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col">Nama Alternatif</th>
                        @foreach ($kriteria as $item)
                            <th>{{ $item }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataal as $d)
                        <tr>
                            <td>{{ $d->nama_alternatif }}</td>
                            @foreach ($kriteria as $kriteriaName)
                                <td>{{ $d->$kriteriaName }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
