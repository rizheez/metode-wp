<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Alternatif::all();
        // dd($data);
        return view('pages.alternatif', compact('data'));
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
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
        ]);

        $alternatif = Alternatif::create([
            'kode' => $request->input('kode'),
            'nama' => $request->input('nama'),
            // Tambahkan kolom-kolom lain yang perlu disimpan di sini
        ]);
        if ($alternatif) {
            // Data berhasil disimpan
            return redirect()->route('alternatif')->with('success', 'Data Alternatif berhasil disimpan');
        } else {
            // Data gagal disimpan
            return redirect()->route('alternatif')->with('error', 'Gagal menyimpan data Alternatif');
        }
        // Kemudian Anda bisa mengembalikan respons atau mengarahkan pengguna

    }

    /**
     * Display the specified resource.
     */
    public function show(Alternatif $alternatif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Alternatif::findOrFail($id);

        return json_encode($data);
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

        ]);

        $alternatif = Alternatif::findOrFail($id);

        // Update data alter$alternatif
        $alternatif->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        if ($alternatif) {
            // Data berhasil disimpan
            return redirect()->route('alternatif')->with('success', 'Data kriteria berhasil diupdate');
        } else {
            // Data gagal diupdate
            return redirect()->route('alternatif')->with('error', 'Gagal mengupdate data kriteria');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Alternatif::truncate();

        return redirect()->route('alternatif')->with('success', 'Data kriteria berhasil dihapus semua');
    }
}
