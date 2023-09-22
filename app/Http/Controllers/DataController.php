<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $k = Kriteria::pluck('kode')->toArray();
        $alternatif = Alternatif::pluck('nama');
        $tableName = 'dataal';
        $kriteria = Kriteria::pluck('kode');
        $tableExists = DB::select("SHOW TABLES LIKE '{$tableName}'");
        if (empty($tableExists)) {
            $sql = "CREATE TABLE {$tableName} (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nama_alternatif VARCHAR(255),";

            foreach ($k as $kriteriaName) {
                $sql .= " $kriteriaName FLOAT,";
            }

            $sql .= ' created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )';

            DB::statement($sql);
        }


        $dataal = DB::table($tableName)->get();

        return view('pages.data', compact(['kriteria', 'alternatif', 'dataal']));
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
        // dd($request->all());
        $kriteria = Kriteria::pluck('kode')->toArray();

        if (empty($kriteria)) {
            return 'Tidak ada kriteria yang ditemukan.';
        }

        $tableName = 'dataal';
        $tableExists = DB::select("SHOW TABLES LIKE '{$tableName}'");

        if (!empty($tableExists)) {
            DB::statement("DROP TABLE {$tableName}");
        }
        $sql = "CREATE TABLE {$tableName} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama_alternatif VARCHAR(255),";

        foreach ($kriteria as $kriteriaName) {
            $sql .= " $kriteriaName FLOAT,";
        }

        $sql .= ' created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )';

        DB::statement($sql);
        try {

            foreach ($request->nilai as $namaAlternatif => $nilaiKriteria) {
                $data = ['nama_alternatif' => $namaAlternatif];
                foreach ($kriteria as $kriteriaName) {
                    if (isset($nilaiKriteria[$kriteriaName])) {
                        $data[$kriteriaName] = $nilaiKriteria[$kriteriaName];
                    }
                }
                DB::table($tableName)->insert($data);
            }

            return redirect()->route('data')->with('success', 'Data berhasil disimpan ke dalam tabel baru.');
        } catch (\Exception $e) {

            return redirect()->route('data')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function calculateWP()
    {
        // Langkah 1: Membuat Matriks Keputusan (Tabel I)
        // mengambil data nilai alternatif dari tabel dataal
        $dataal = DB::table('dataal')->get();

        // Langkah 2: Melakukan Normalisasi Bobot (Tabel II)
        // Ambil data bobot kriteria dari tabel kriteria
        $kriteria = Kriteria::all();

        // Normalisasi bobot kriteria
        $totalBobot = $kriteria->sum('bobot');
        $bobot_normalized = [];
        foreach ($kriteria as $k) {
            $b = round($k->bobot / $totalBobot, 4);

            if ($k->jenis_kriteria == 'benefit') {
                $bobot_normalized[] = $b;
            } else {
                $bobot_normalized[] = -1 * $b;
            }
        }

        // Langkah 3: Memangkatkan Nilai Alternatif (Tabel III)
        // menghitung vektor S untuk setiap alternatif dengan bobot yang sudah dinormalisasi
        $vektorS = [];

        foreach ($dataal as $alt) {
            $s = 1;

            foreach ($kriteria as $key => $k) {
                $s *= round(pow($alt->{$k->kode}, $bobot_normalized[$key]), 4);
            }

            $vektorS[$alt->nama_alternatif] = $s;
        }

        // dd($vektorS);

        // Langkah 4: Menghitung Preferensi (Tabel IV)
        // menjumlahkan hasil perkalian pada setiap baris Tabel III, kemudian membaginya dengan jumlah baris
        $totalVektorS = array_sum($vektorS);
        $preferensi = [];

        foreach ($vektorS as $nama_alternatif => $nilaiS) {
            $preferensi[$nama_alternatif] = round($nilaiS / $totalVektorS, 4);
        }
        // dd($preferensi);
        $tableName = 'rankup';
        $tableExists = DB::select("SHOW TABLES LIKE '{$tableName}'");

        if (!empty($tableExists)) {
            DB::statement("DROP TABLE {$tableName}");
        }
        $sql = "CREATE TABLE {$tableName} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama_alternatif VARCHAR(255),
            ranking INT,
            V float,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        DB::statement($sql);

        $rankingList = [];
        foreach ($preferensi as $nama_alternatif => $nilaiV) {
            $rankingList[$nama_alternatif] = $nilaiV;
        }

        arsort($rankingList);
        $ranking = 0;
        try {
            foreach ($rankingList as $nama_alternatif => $nilaiV) {
                DB::table('rankup')->insert([
                    'nama_alternatif' => $nama_alternatif,
                    'ranking' => $ranking + 1,
                    'V' => $nilaiV,
                ]);
                $ranking++;
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }

        return view('pages.metodewp', compact(['dataal', 'kriteria', 'vektorS', 'preferensi']));
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        $tableName = 'rankup';
        $data = DB::select("select * from {$tableName}");
        // dd($data);
        return view('pages.hasil', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
