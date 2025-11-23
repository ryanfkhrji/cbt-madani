@extends('layouts.admin')
@section('content-admin')
<div class="min-h-screen p-4 mt-16">
    <div class="grid grid-cols-1">
        <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
            <div class="card-body">
                <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Import Soal Ujian</h3>
                <form action="{{route('soal.import')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <div class="p-4 bg-gray-100 rounded-sm dark:bg-gray-600">
                            <h4 class="mb-4 text-sm font-medium text-black-custom dark:text-white-custom">
                                Gunakan format Excel yang disediakan untuk import data dari Excel. Jika soal mengandung Gambar maka taro gambarnya di line excel.
                            </h4>
                            <a href="{{route('soal.template')}}" class="bg-black btn text-white-custom"><i class="fa-solid fa-file-excel"></i>Download Format</a>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="file" class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">File Import</label>
                        <input type="file" class="w-full max-w-xs file-input" name="file" id="file" />
                    </div>
                    <div class="flex flex-wrap gap-1 pt-4">
                        <button type="submit" class="bg-black btn text-white-custom"><i class="fa-solid fa-file-import"></i>Import</button>
                        <button type="button" onclick="{window.location.href='{{ route('master_soal.index') }}'}" class="border border-black btn text-black-custom dark:text-white-custom" id="batal"><i class="fa-regular fa-circle-xmark text-black-custom dark:text-white-custom"></i>Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
