<?php

namespace App\Http\Controllers;

use App\Models\UjianJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StartController extends Controller
{
    public function simpanJawaban(Request $request)
    {
        $request->validate([
            'id_ujian' => 'required|exists:ujian,id',
            'id_soal'  => 'required|exists:soals,id',
            'jawaban'  => 'nullable|string',
        ]);

        $jawabanBenar = \App\Models\Soal::where('id', $request->id_soal)->value('jawaban_benar');

        UjianJawaban::updateOrCreate(
            [
                'id_user' => Auth::id(),
                'id_ujian' => $request->id_ujian,
                'id_soal' => $request->id_soal,
            ],
            [
                'jawaban' => $request->jawaban,
                'jawaban_benar' => $jawabanBenar
            ]
        );

        return response()->json(['success' => true]);
    }
}
