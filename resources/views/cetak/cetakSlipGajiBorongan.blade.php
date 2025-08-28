<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji Spet</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            @foreach($data_gajian_borongan as $data)
                <div class="col p-0">
                    <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
                        <tr>
                        <td style="border: 1px solid black; padding: 8px; text-align: left;" colspan="5">{{ $data->dataKaryawanBorongan->nama_karyawan }}</td>
                        </tr>
                        <tr>
                        <td style="text-align: right;">{{ $data->jumlah_s }}</td>
                        <td style="text-align: center;">x</td>
                        <td style="text-align: right;">{{ number_format($data->dataKaryawanBorongan->harga_s) }}</td>
                        <td style="text-align: center;">=</td>
                        <td style="text-align: right;">{{ number_format($data->jumlah_s * $data->dataKaryawanBorongan->harga_s) }}</td>
                        </tr>
                        <tr>
                        <td style="text-align: right;">{{ $data->jumlah_o }}</td>
                        <td style="text-align: center;">x</td>
                        <td style="text-align: right;">{{ number_format($data->dataKaryawanBorongan->harga_o) }}</td>
                        <td style="text-align: center;">=</td>
                        <td style="text-align: right;">{{ number_format($data->jumlah_o * $data->dataKaryawanBorongan->harga_o) }}</td>
                        </tr>
                        <tr>
                        <td style="text-align: right;">{{ $data->jumlah_masuk }}</td>
                        <td style="text-align: center;">x</td>
                        <td style="text-align: right;">{{ number_format($data->dataKaryawanBorongan->makan) }}</td>
                        <td style="text-align: center;">=</td>
                        <td style="text-align: right;">{{ number_format($data->jumlah_masuk * $data->dataKaryawanBorongan->makan) }}</td>
                        </tr>
                        <tr>
                        <td style="text-align: right;">{{ $data->jumlah_bonus }}</td>
                        <td style="text-align: center;">x</td>
                        <td style="text-align: right;">{{ number_format($data->dataKaryawanBorongan->tunjangan) }}</td>
                        <td style="text-align: center;">=</td>
                        <td style="text-align: right;">{{ number_format($data->jumlah_bonus * $data->dataKaryawanBorongan->tunjangan) }}</td>
                        </tr>
                        @if ($data->dataKaryawanBorongan->tunjangan != 0)
                        <tr>
                        <td style="text-align: right;">{{ $data->jumlah_bonus }}</td>
                        <td style="text-align: center;">x</td>
                        <td style="text-align: right;">{{ number_format($data->dataKaryawanBorongan->tunjangan) }}</td>
                        <td style="text-align: center;">=</td>
                        <td style="text-align: right;">{{ number_format($data->jumlah_bonus * $data->dataKaryawanBorongan->tunjangan) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        <td></td>
                        <td style="text-align: right; border-top: 1px solid black;">{{ number_format($data->total_gaji) }}</td>
                        </tr>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
</body>