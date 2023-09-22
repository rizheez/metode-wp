<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kriteria::all();
        return view('pages.kriteria', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate()

        $kriteria = Kriteria::create([
            'kode' => $request->input('kode'),
            'nama' => $request->input('nama'),
            'jenis_kriteria' => $request->input('jenis_kriteria'),
            'bobot' => $request->input('bobot'),
        ]);

        if ($kriteria) {
            // Data berhasil disimpan
            return redirect()->route('kriteria')->with('success', 'Data kriteria berhasil disimpan');
        } else {
            // Data gagal disimpan
            return redirect()->route('kriteria')->with('error', 'Gagal menyimpan data kriteria');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kriteria $kriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);

        return json_encode($kriteria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'jenis_kriteria' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric',
        ]);

        $kriteria = Kriteria::findOrFail($id);

        // Update data kriteria
        $kriteria->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'jenis_kriteria' => $request->jenis_kriteria,
            'bobot' => $request->bobot,
        ]);

        if ($kriteria) {
            // Data berhasil disimpan
            return redirect()->route('kriteria')->with('success', 'Data kriteria berhasil diupdate');
        } else {
            // Data gagal diupdate
            return redirect()->route('kriteria')->with('error', 'Gagal mengupdate data kriteria');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Kriteria::truncate();

        // Redirect dengan pesan sukses
        return redirect()->route('kriteria')->with('success', 'Semua data kriteria berhasil dihapus');
    }
}
