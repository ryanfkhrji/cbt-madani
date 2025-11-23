<?php

namespace App\Http\Controllers;

use App\Models\UjianJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class JawabUjianController extends Controller
{
   public function simpanJawaban(Request $request)
    {
        try {
            $request->validate([
                'id_ujian' => 'required|exists:ujians,id',
                'id_soal'  => 'required|exists:soals,id',
                'jawaban'  => 'nullable',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }

        $jawabanBenar = \App\Models\Soal::findOrFail($request->id_soal);

        UjianJawaban::updateOrCreate(
            [
                'id_user' => Auth::id(),
                'id_ujian' => $request->id_ujian,
                'id_soal' => $request->id_soal,
            ],
            [
                'jawaban' => $request->jawaban,
                'jawaban_benar' => $jawabanBenar->jawaban_benar
            ]
        );

        return response()->json(['success' => true]);
    }
}
