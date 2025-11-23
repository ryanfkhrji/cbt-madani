<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Kartu Ujian</title>
    <!-- fontawesome -->
        <link rel="stylesheet" href="/fontawesome/css/all.min.css" />

    <!-- favicon -->
        <link rel="icon" type="image/svg+xml" href="/assets/logo-sekolah.png">

        {{-- @vite('resources/css/app.css') --}}

    <style>
        .kartu-container {
            display: flex;
            flex-wrap: wrap;   /* biar turun ke bawah kalau penuh */
        }

        .kartu {
            width: 40%;
            margin: 1%;
            border: 1px solid #999;
            padding: 16px;
            box-sizing: border-box;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        h3 {
            text-align: center;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 5px;
        }

        @media print {
            .kartu {
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    @foreach ($siswas as $siswa)
    <div class="kartu-container">
        <div class="kartu">
            <h3>Kartu Ujian</h3>
            <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
            <p><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas ?? '-' }}</p>
            <p><strong>Username:</strong> {{ $siswa->nis }}</p>
            <p><strong>Password:</strong> {{ $siswa->password }}</p>
        </div>
    </div>
        @endforeach
</body>
</html>
