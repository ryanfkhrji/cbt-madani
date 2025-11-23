<?php

namespace App\Http\Controllers;

use App\Exports\TemplateSoal;
use App\Imports\ImportSoal;
use App\Models\Soal;
use App\Models\Ujian;
use App\Models\Kategori;
use App\Models\SoalUjian;
use App\Models\SoalPilihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Symfony\Contracts\Service\Attribute\Required;

class MasterSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ujian = Ujian::all();

        $soalQuery = Soal::with('ujian');

        if ($request->has('ujian_id') && $request->ujian_id != '') {
            $soalQuery->where('id_ujian', $request->ujian_id);
        }

        $soal = $soalQuery->paginate(10)->withQueryString();

        return view('soal.index', compact('soal', 'ujian'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ujian = Ujian::all();
        $kategori = Kategori::all();
        return view('soal.create', compact('kategori', 'ujian'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'id_ujian' => 'required|exists:ujians,id',
            'id_kategori_soal' => 'required|exists:kategoris,id',
            'id_kategori_jawaban' => 'required|exists:kategoris,id',
            'jawaban_benar' => 'required|in:1,2,3,4,5',
            'poin' => 'required|numeric|min:0',
        ]);

        // Enforce kategori mapping: 1=text, 2=image
        $kategoriSoal = (int) $request->id_kategori_soal;
        $kategoriJawaban = (int) $request->id_kategori_jawaban;

        $dynamicRules = [];
        if ($kategoriSoal === 1) {
            $dynamicRules['soal'] = 'required|string';
        } elseif ($kategoriSoal === 2) {
            $dynamicRules['soal'] = 'required|image|max:4096';
        }

        for ($i = 1; $i <= 5; $i++) {
            $key = "pilihan_{$i}";
            if ($kategoriJawaban === 1) {
                $dynamicRules[$key] = 'required|string';
            } elseif ($kategoriJawaban === 2) {
                $dynamicRules[$key] = 'required|image|max:4096';
            }
        }
        if (!empty($dynamicRules)) {
            $request->validate($dynamicRules);
        }

        // Handle soal per kategori
        if ($kategoriSoal === 1) {
            $soalValue = $request->input('soal');
        } else { // 2 = image
            $soalValue = $request->file('soal')->store('soal_images', 'public');
        }

        // Handle pilihan per kategori
        $pilihan = [];
        for ($i = 1; $i <= 5; $i++) {
            $key = "pilihan_{$i}";
            if ($kategoriJawaban === 1) {
                $pilihan[$key] = $request->input($key);
            } else { // 2 = image
                $pilihan[$key] = $request->file($key)->store('pilihan_images', 'public');
            }
        }

        // Simpan data
        Soal::create([
            'id_ujian' => $request->id_ujian,
            'id_kategori_soal' => $request->id_kategori_soal,
            'soal' => $soalValue,
            'id_kategori_jawaban' => $request->id_kategori_jawaban,
            'pilihan_1' => $pilihan['pilihan_1'],
            'pilihan_2' => $pilihan['pilihan_2'],
            'pilihan_3' => $pilihan['pilihan_3'],
            'pilihan_4' => $pilihan['pilihan_4'],
            'pilihan_5' => $pilihan['pilihan_5'],
            'jawaban_benar' => $request->jawaban_benar,
            'poin' => $request->poin
        ]);

        return redirect()->back()->with('success', 'Soal berhasil disimpan!');
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
        $ujian = Ujian::all();
        $kategori = Kategori::all();
        $soal = Soal::findOrFail(base64_decode($id));
        return view('soal.edit', compact('soal', 'ujian', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $soal = Soal::findOrFail($id);
        $request->validate([
            'id_ujian' => 'required|exists:ujians,id',
            'id_kategori_soal' => 'required|exists:kategoris,id',
            'id_kategori_jawaban' => 'required|exists:kategoris,id',
            'jawaban_benar' => 'required|in:1,2,3,4,5',
            'poin' => 'required|numeric|min:0',
        ]);

        // Enforce kategori mapping: 1=text, 2=image
        $kategoriSoal = (int) $request->id_kategori_soal;
        $kategoriJawaban = (int) $request->id_kategori_jawaban;

        $dynamicRules = [];
        if ($kategoriSoal === 1) {
            $dynamicRules['soal'] = 'required|string';
        } elseif ($kategoriSoal === 2) {
            $dynamicRules['soal'] = 'nullable|image|max:4096';
        }
        for ($i = 1; $i <= 5; $i++) {
            $key = "pilihan_{$i}";
            if ($kategoriJawaban === 1) {
                $dynamicRules[$key] = 'required|string';
            } elseif ($kategoriJawaban === 2) {
                $dynamicRules[$key] = 'nullable|image|max:4096';
            }
        }
        if (!empty($dynamicRules)) {
            $request->validate($dynamicRules);
        }

        // Handle soal per kategori
        if ($kategoriSoal === 1) {
            // Ensure text; delete old image if existed
            if (!empty($soal->soal) && Storage::disk('public')->exists($soal->soal)) {
                Storage::disk('public')->delete($soal->soal);
            }
            $soalValue = $request->input('soal');
        } else { // image
            $soalValue = $soal->soal; // default keep existing
            if ($request->hasFile('soal')) {
                $soalValue = $request->file('soal')->store('soal_images', 'public');
                if (!empty($soal->soal) && Storage::disk('public')->exists($soal->soal)) {
                    Storage::disk('public')->delete($soal->soal);
                }
            }
        }

        // Handle pilihan 1-5 per kategori
        $pilihan = [];
        for ($i = 1; $i <= 5; $i++) {
            $key = "pilihan_{$i}";
            $currentValue = $soal->$key;

            if ($kategoriJawaban === 1) {
                // Text answers: delete old image if any and set text
                if (!empty($currentValue) && Storage::disk('public')->exists($currentValue)) {
                    Storage::disk('public')->delete($currentValue);
                }
                $pilihan[$key] = $request->input($key);
            } else { // image answers
                if ($request->hasFile($key)) {
                    $pilihan[$key] = $request->file($key)->store('pilihan_images', 'public');
                    if (!empty($currentValue) && Storage::disk('public')->exists($currentValue)) {
                        Storage::disk('public')->delete($currentValue);
                    }
                } else {
                    // Keep existing image if not replaced
                    $pilihan[$key] = $currentValue;
                }
            }
        }

        // Simpan data
        $soal->update([
            'id_ujian' => $request->id_ujian,
            'id_kategori_soal' => $request->id_kategori_soal,
            'soal' => $soalValue,
            'id_kategori_jawaban' => $request->id_kategori_jawaban,
            'pilihan_1' => $pilihan['pilihan_1'],
            'pilihan_2' => $pilihan['pilihan_2'],
            'pilihan_3' => $pilihan['pilihan_3'],
            'pilihan_4' => $pilihan['pilihan_4'],
            'pilihan_5' => $pilihan['pilihan_5'],
            'jawaban_benar' => $request->jawaban_benar,
            'poin' => $request->poin
        ]);

        return redirect()->back()->with('success', 'Soal berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $soal = Soal::findOrFail($id);
        // Delete associated images if they exist
        if (!empty($soal->soal) && Storage::disk('public')->exists($soal->soal)) {
            Storage::disk('public')->delete($soal->soal);
        }
        for ($i = 1; $i <= 5; $i++) {
            $key = 'pilihan_' . $i;
            if (!empty($soal->$key) && Storage::disk('public')->exists($soal->$key)) {
                Storage::disk('public')->delete($soal->$key);
            }
        }

        $soal->delete();

        return redirect()->route('master_soal.index')->with('soal berhasil di hapus');
    }

    // hapus semua soal
    public function deleteAll(Request $request)
    {
        $request->validate([
            'id_ujian' => 'required|exists:ujians,id'
        ]);

        $soals = Soal::where('id_ujian', $request->id_ujian)->get();

        foreach ($soals as $soal) {

            // Hapus soal jika bentuknya gambar
            if ($soal->soal && preg_match('/\.(jpg|jpeg|png|gif)$/i', $soal->soal)) {

                // Ubah storage/soal_images/... => soal_images/...
                $filePath = str_replace('storage/', '', $soal->soal);

                Storage::disk('public')->delete($filePath);
            }

            // Hapus pilihan gambar
            for ($i = 1; $i <= 5; $i++) {
                $key = 'pilihan_' . $i;

                if ($soal->$key && preg_match('/\.(jpg|jpeg|png|gif)$/i', $soal->$key)) {

                    $pilihanPath = str_replace('storage/', '', $soal->$key);

                    Storage::disk('public')->delete($pilihanPath);
                }
            }

            // Hapus data soal dari database
            $soal->delete();
        }

        return redirect()->route('master_soal.index')->with('success', 'Semua soal berhasil dihapus!');
    }

    public function createAll(string $id)
    {
        // Mendapatkan ujian dan jumlah soal
        $ujian = Ujian::findOrFail(base64_decode($id)); // Ambil data ujian
        $jumlah_soal = $ujian->jumlah_soal; // Ambil jumlah soal dari ujian
        $kategori = Kategori::all();
        return view('soal.create-soal-all', compact('ujian', 'jumlah_soal', 'kategori'));
    }

    public function storeAllExamp(Request $request)
    {

        DB::beginTransaction();
        try {
            // Validate the exam ID first
            $validator = Validator::make($request->all(), [
                'id_ujian' => 'required|exists:ujians,id',
            ]);

            if ($validator->fails()) {
                throw new \Exception('Invalid exam ID');
            }

            // Loop through each question
            foreach ($request->input('soal', []) as $i => $soalData) {
                // Normalize pilihan array to ensure keys 0 to 4 exist
                if (!isset($soalData['pilihan']) || !is_array($soalData['pilihan'])) {
                    throw new \Exception("pilihan field is required for question $i");
                }

                $normalizedPilihan = [];
                for ($j = 0; $j < 5; $j++) {
                    if (isset($soalData['pilihan'][$j + 1])) {
                        $pilihan = $soalData['pilihan'][$j + 1];
                        $normalizedPilihan[$j] = [
                            'text' => $pilihan['text'] ?? null, // Ambil text jika ada
                            'image' => $pilihan['image'] ?? null, // Ambil image jika ada
                        ];
                    } else {
                        // Jika pilihan tidak ada, buat pilihan kosong
                        $normalizedPilihan[$j] = ['text' => null, 'image' => null];
                    }
                }
                // Ganti pilihan dengan pilihan yang dinormalisasi
                $soalData['pilihan'] = $normalizedPilihan;

                // Validate the question with updated pilihan array
                $questionValidator = Validator::make($soalData, [
                    'id_kategori_soal' => 'required|in:1,2',
                    'id_kategori_jawaban' => 'required|in:1,2',
                    'text' => [
                        function ($attribute, $value, $fail) use ($soalData) {
                            if (($soalData['id_kategori_soal'] ?? null) == 1 && empty($value)) {
                                $fail('Kolom teks pertanyaan wajib diisi karena kategori soal adalah teks.');
                            }
                        }
                    ],
                    // File requirements validated against request below
                    'image' => ['nullable'],
                    'jawaban_benar' => 'required|in:1,2,3,4,5',
                    'poin' => 'required|numeric|min:0',
                    'pilihan' => 'required|array|size:5',
                    'pilihan.*.text' => [
                        function ($attribute, $value, $fail) use ($soalData) {
                            if (($soalData['id_kategori_jawaban'] ?? null) == 1 && empty($value)) {
                                $fail("Pilihan teks wajib diisi karena kategori jawaban adalah teks.");
                            }
                        }
                    ],
                    // File requirements checked using request below; keep structure validation light
                    'pilihan.*.image' => ['nullable'],
                ]);

                if ($questionValidator->fails()) {
                    throw new \Exception("Validation failed for question $i: " . $questionValidator->errors()->first());
                }

                // Additional file presence checks against request
                if (($soalData['id_kategori_soal'] ?? null) == 2 && !$request->hasFile("soal.$i.image")) {
                    throw new \Exception("Gambar pertanyaan wajib diunggah karena kategori soal adalah gambar (soal $i).");
                }
                if (($soalData['id_kategori_jawaban'] ?? null) == 2) {
                    for ($jj = 1; $jj <= 5; $jj++) {
                        if (!$request->hasFile("soal.$i.pilihan.$jj.image")) {
                            throw new \Exception("Pilihan $jj gambar wajib diunggah karena kategori jawaban adalah gambar (soal $i).");
                        }
                    }
                }

                // Prepare data to save, initially assign text or image path for pilihan after file uploads
                $soalDataToSave = [
                    'id_ujian' => $request->id_ujian,
                    'id_kategori_soal' => $soalData['id_kategori_soal'],
                    'id_kategori_jawaban' => $soalData['id_kategori_jawaban'],
                    'jawaban_benar' => $soalData['jawaban_benar'],
                    'poin' => $soalData['poin'],
                    'soal' => $soalData['text'] ?? null,
                    // Initialize pilihan with text; will update if images uploaded
                    'pilihan_1' => $soalData['pilihan'][0]['text'] ?? null,
                    'pilihan_2' => $soalData['pilihan'][1]['text'] ?? null,
                    'pilihan_3' => $soalData['pilihan'][2]['text'] ?? null,
                    'pilihan_4' => $soalData['pilihan'][3]['text'] ?? null,
                    'pilihan_5' => $soalData['pilihan'][4]['text'] ?? null,
                ];

                // Handle file upload for soal image if exists
                if ($request->hasFile("soal.$i.image")) {
                    $image = $request->file("soal.$i.image");
                    $path = $image->store('soal_images', 'public');
                    $soalDataToSave['soal'] = $path; // Assuming 'soal' field stores image path if image question
                }

                // Handle file uploads for each pilihan image if exists and update pilihan text fields to image path
                for ($j = 1; $j <= 5; $j++) {
                    if ($request->hasFile("soal.$i.pilihan.$j.image")) {
                        $choiceImage = $request->file("soal.$i.pilihan.$j.image");
                        $choicePath = $choiceImage->store('pilihan_images', 'public');
                        $soalDataToSave["pilihan_" . $j] = $choicePath; // Override text with image path if image uploaded
                    }
                }

                // Create and save new Soal record with prepared data
                $soal = Soal::create($soalDataToSave);
            }

            DB::commit();
            return redirect()->back()->with('success', 'All questions saved successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to save: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function storeSoal(Request $request)
    {



        $index = 0;
        while ($request->has("question_title_$index")) {
            $tipe = $request->input("question_type_$index");
            $judul = $request->input("question_title_$index");
            $required = $request->has("question_required_$index");
            $gambar = $request->file("question_image_$index");

            // Simpan gambar jika ada
            $gambarPath = null;
            if ($gambar) {
                $gambarPath = $gambar->store('soal_gambar', 'public');
            }

            // Simpan soal utama
            $soal = SoalUjian::create([
                'id_ujian' => 1, // sesuaikan
                'soal' => $judul,
                'tipe' => $tipe,
                'required' => $required,
                'gambar' => $gambarPath,
                'poin' => 10
            ]);

            // Jika pilihan ganda atau checkbox
            if (in_array($tipe, ['multiple', 'checkbox'])) {
                $pilihanList = $request->input("question_options_$index", []);
                $jawabanBenar = $request->input("question_answer_$index");

                foreach ($pilihanList as $opt) {
                    SoalPilihan::create([
                        'soal_ujian_id' => $soal->id,
                        'teks_pilihan' => $opt,
                        'is_benar' => $opt === $jawabanBenar,
                    ]);
                }
            }

            $index++;
        }

        return redirect()->route('master_soal.index')->with('success', 'Soal berhasil disimpan!');
    }

    public function exportTemplate()
    {
        return Excel::download(new TemplateSoal, 'template_soal.xlsx');
    }

    public function viewImport()
    {
        return view('soal.import');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ImportSoal, $request->file('file'));

        return redirect()->route('master_soal.index')->with('success', 'Data Soal berhasil diimpor.');
    }
}
