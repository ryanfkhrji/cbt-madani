<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class MasterJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwal = Jadwal::with('ujian')->paginate(50);
        return view('jadwal.index', compact('jadwal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ujian = Ujian::all();
        return view('jadwal.create', compact('ujian'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_ujian' => 'exists:ujians,id',
            'nama_jadwal' => 'required',
            'hari' => 'required|string',
            'tanggal' => 'required',
            'jam_in' => 'required',
            'jam_out' => 'required'
        ]);

        Jadwal::create($validated);
        return redirect()->route('master_jadwal.index')->with('success', 'Data Jadwal Berhasil di tambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jadwal = Jadwal::findOrFail(base64_decode($id));
        $ujian = Ujian::all();
        return view('jadwal.edit', compact('jadwal', 'ujian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $validated = $request->validate([
            'id_ujian' => 'exists:ujians,id',
            'nama_jadwal' => 'required',
            'hari' => 'required|string',
            'tanggal' => 'required',
            'jam_in' => 'required',
            'jam_out' => 'required'
        ]);
        $jadwal->update($validated);
        return redirect()->route('master_jadwal.index')->with('success', 'Data Jadwal Berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('master_jadwal.index')->with('success', 'Data Jadwal Berhasil di hapus');
    }
}
