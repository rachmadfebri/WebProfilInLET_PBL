<!DOCTYPE html>
<html>
<head>
    <title>Laporan Buku Tamu - Lab InLET</title>
    <style>
        /* Reset & General Styles */
        body { 
            font-family: "Times New Roman", Times, serif; /* Font resmi laporan */
            padding: 40px; 
            color: #000;
            line-height: 1.5;
        }
        
        /* Header Laporan */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2 { 
            margin: 0; 
            font-size: 18pt; 
            text-transform: uppercase; 
        }
        .header h4 { 
            margin: 5px 0; 
            font-size: 14pt; 
            font-weight: normal; 
        }
        .header p { 
            margin: 0; 
            font-size: 11pt; 
        }

        /* Tabel Laporan */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            font-size: 12pt;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 8px 10px; 
            text-align: left; 
            vertical-align: top;
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold; 
            text-align: center;
        }
        
        /* Kolom Nomor Kecil */
        td:first-child, th:first-child {
            text-align: center;
            width: 5%;
        }

        /* Footer Tanda Tangan */
        .footer { 
            margin-top: 50px; 
            text-align: right; 
            font-size: 12pt;
            width: 300px;
            float: right;
        }
        .signature-space {
            height: 80px;
        }

        /* Tombol Cetak (Hanya tampil di layar) */
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #7928ca;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: sans-serif;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .print-btn:hover {
            background-color: #621b9e;
        }

        /* Styles Khusus Saat Print */
        @media print {
            @page { 
                size: A4; 
                margin: 2cm; 
            }
            body { 
                padding: 0; 
            }
            .no-print, .print-btn { 
                display: none !important; 
            }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Tombol ini akan hilang saat dicetak -->
    <button class="print-btn no-print" onclick="window.print()">Cetak Laporan</button>

    <!-- Header Laporan -->
    <div class="header">
        <h2>Laboratorium InLET</h2>
        <h4>Laporan Buku Tamu</h4>
        <p>
            Periode: <?= date('d F Y', strtotime($startDate)) ?> 
            s/d <?= date('d F Y', strtotime($endDate)) ?>
        </p>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
                <th>Nama Lengkap</th>
                <th>Instansi / Asal</th>
                <th>Keperluan / Pesan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if (!empty($dataLaporan)): 
                foreach ($dataLaporan as $row): 
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>
                    <?= date('d/m/Y', strtotime($row['sent_at'])) ?><br>
                    <small><?= date('H:i', strtotime($row['sent_at'])) ?> WIB</small>
                </td>
                <td>
                    <strong><?= htmlspecialchars($row['name']) ?></strong><br>
                    <?php if(!empty($row['phone_number'])): ?>
                        <small>Telp: <?= htmlspecialchars($row['phone_number']) ?></small>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['institution'] ?? '-') ?></td>
                <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            </tr>
            <?php 
                endforeach; 
            else:
            ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">
                    <em>Tidak ada data tamu pada periode tanggal ini.</em>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Footer Tanda Tangan -->
    <div class="footer">
        <p>Malang, <?= date('d F Y') ?></p>
        <p>Mengetahui,</p>
        <div class="signature-space"></div>
        <p><strong>( <?= htmlspecialchars($_SESSION['full_name'] ?? 'Admin Lab InLET') ?> )</strong></p>
    </div>

</body>
</html>