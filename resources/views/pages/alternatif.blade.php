@extends('layouts.main')
@section('title', 'alternatif')

@section('main')
    <div>
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
        <div class="d-flex justify-content-end">
            <button type="button" class="me-2 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add
            </button>
            <form action="{{ route('kriteria.delete') }}">
                @method('delete')
                <button type="submit" class="btn btn-danger">Delete All</button>
            </form>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Nama Alternatif</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $d->kode }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>
                            <button class="me-2 btn btn-success edit-button" data-bs-toggle="modal"
                                data-bs-target="#editModal" data-record-id="{{ $d->id }}">Edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!--Add Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('alternatif.store') }}" method="POST">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode</label>
                                @php
                                    $kode = ''; // Inisialisasi $kode di luar foreach
                                    $lastRow = null;
                                @endphp

                                @foreach ($data as $d)
                                    @php
                                        $lastRow = $d->id;
                                        $kode = 'A' . ($lastRow + 1);
                                    @endphp
                                @endforeach

                                @if ($lastRow === null)
                                    @php
                                        $kode = 'A1'; // Jika $lastRow null, beri nilai default 'C1'
                                    @endphp
                                @endif
                                <input type="text" class="form-control" id="kode" value="{{ $kode }}"
                                    name="kode" aria-describedby="kode">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Alternatif</label>
                                <input type="text" class="form-control" id="nama" name="nama">
                            </div>

                            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('alternatif.update', ':id') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode</label>

                                <input type="text" class="form-control" id="edit-kode" name="kode"
                                    aria-describedby="kode">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Alternatif</label>
                                <input type="text" class="form-control" id="edit-nama" name="nama">
                            </div>

                            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const editButtons = document.querySelectorAll('.edit-button');
        const editForm = document.querySelector('#editModal form');

        editButtons.forEach((button) => {
            button.addEventListener('click', function() {
                const recordId = this.getAttribute('data-record-id');

                // Mengirim permintaan AJAX untuk mengambil data dari server
                fetch(`http://localhost:8000/alternatif/${recordId}`)
                    .then(async response => data = await response.json())
                    .then(data => {
                        // Mengisi nilai-nilai form dengan data dari server
                        const kodeInput = document.getElementById('edit-kode');
                        const namaInput = document.getElementById('edit-nama');


                        kodeInput.value = data.kode;
                        namaInput.value = data.nama;


                        // Mengatur action form
                        const formAction = editForm.getAttribute('action');
                        editForm.setAttribute('action', formAction.replace(':id', recordId));
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>
@endsection
