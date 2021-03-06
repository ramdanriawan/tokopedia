<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

ini_set('max_execution_time', 0);
ob_start();

class TokopediaController extends Controller
{
    public function index()
    {
        $folderCekGambar  = glob(public_path('tokopedia/file_lama/271386/*.xlsx'));
        $folderUbahStatus = glob(public_path('tokopedia/file_lama/271385/*.xlsx'));
        // untuk membuat open link in new tab javascript
        if (!request()->file_ke && !request()->baris_ke) {
            for ($i = $_GET['start_dari']; $i < $_GET['berhenti_di']; $i++) {

                echo "<script>window.open(\"?file_ke=$i&baris_ke=4\", \"_blank\"); </script>";
            }

            return false;
        }

        $file_ke = $_GET['file_ke'];
        $fileSaveName = 'tokopedia/file_update/TOKOPEDIA_PRODUCT_UPDATE_' . time() . '.xlsx';
        for ($a = $file_ke; $a < count($folderCekGambar); $a++) {
            $file_excel = $folderCekGambar[$a];
            $worksheet  = \PHPExcel_IOFactory::createReaderForFile($file_excel)->load($file_excel)->getSheet(0);

            // update produk
            $excel2 = \PHPExcel_IOFactory::createReader(\PHPExcel_IOFactory::identify($folderUbahStatus[$a]));
            $excel2 = $excel2->load($folderUbahStatus[$a]);
            $excel2->setActiveSheetIndex(0);

            $objWriter = \PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
            $gambar       = [];
            for ($row = $_GET['baris_ke']; $row <= $worksheet->getHighestRow(); $row++) {
                $nomor = $row - 3;

                echo "File ke $file_ke, item ke $nomor : " . $worksheet->getCell("B{$row}")->getValue() . "<br>";
                if (ob_get_contents()) {
                    ob_end_clean();
                }

                $gambar[] = (string) $worksheet->getCell("L{$row}")->getValue();
                $gambar[] = (string) $worksheet->getCell("M{$row}")->getValue();
                $gambar[] = (string) $worksheet->getCell("N{$row}")->getValue();
                $gambar[] = (string) $worksheet->getCell("O{$row}")->getValue();
                $gambar[] = (string) $worksheet->getCell("P{$row}")->getValue();

                foreach ($gambar as $key => $item) {

                    // kalo gambarnya gak ada ya g usah dicek
                    if (empty($item)) {
                        continue;
                    }

                    $data = [
                        'apikey'    => 'OCRK8154898A',
                        'url'       => $item,
                        'OCREngine' => 2,
                    ];
                    
//                    $data = [
//                        'apikey'    => '3e877b7c3188957',
//                        'url'       => $item,
//                        'OCREngine' => 2,
//                    ];

                    try {
                        $client = new \GuzzleHttp\Client();
                        $res    = $client->request('POST', "https://apipro3.ocr.space/parse/image", [
                            'form_params' => $data,
                        ]);
                        
//                        $client = new \GuzzleHttp\Client();
//                        $res    = $client->request('POST', "https://api.ocr.space/parse/image", [
//                            'form_params' => $data,
//                        ]);
//                        
//                        $client = new \GuzzleHttp\Client();
//                        $res    = $client->request('GET', "https://api.ocr.space/parse/imageUrl?" . http_build_query($data));

                        $ParsedResults = json_decode($res->getBody())->ParsedResults;

                        if (count($ParsedResults)) {

                            $ParsedText = $ParsedResults[0]->ParsedText;

                            // kata yang akan difilter
                            $kataFilter = [
                                'toko', 'store', 'shop', 'fashion', 'cloth',
                                'bukalapak', 'acc', 'part', 'bike', 'sport', 'bola', 'futsal',
                                'badminton', 'tenis', 'motor', 'helm', 'jaket', 'boots', 'sepatu', 'glass', 'glasses',
                                'shoes', 'bag', 'gloves', 'aksesoris', 'outwear', 'grosir', 
                                'mobil', 'jok', 'cd', 'dvd', 'ac', 'spion', 'elektronik', 'smartphone', 'watch',
                                'cell', 'konter', 'screen', 'laptop', 'soft', 'software', 'aksesoris', 
                                'musik', 'collection', 'design', 'clinic', 'klinik', 'tani', 'game', 'doll', 
                                'php', 'pancing', 'hair', 'industri', 'baby', 'watch', 'game', 'food', 'beuty', 'makeup', 'make up',
                                'tools', 'machine', 'furniture', 'kitchen', 'clock', 'cake', 'by', 'by: ', '.com'
                            ];

                            foreach ($kataFilter as $kataFilterItem) {
                                if(preg_match("/$kataFilterItem/", $ParsedText) || empty($ParsedText)) {
                                    
                                    echo "Ketemu nih produk yg ada watermarknya, mantulll : $file_ke | $fileSaveName | $gambar | $kataFilterItem | $ParsedText <br>";
                                    $excel2->getActiveSheet()->setCellValue("I$row", 'Nonaktif');
                                    $objWriter->save($fileSaveName);
                                    
                                    continue 3;
                                }
                            }
                        }
                    } catch (\Exception $e) {

                        $timeLimit = 0;
                        while (true) {
                            if ($timeLimit == 60) {
                                break;
                            }

                            $timeLimit += 1;

                            echo "Lagi limit gannnn, tunggu sampai 60 yah. ini baru: $timeLimit";

                            echo "<br>";

                            sleep(1);
                        }
                    }
                }
                            
                // update produk jika emang tidak ada error sih, tetap update lah pokoknya
                if(!file_exists(public_path($fileSaveName))) {

                    $objWriter->save($fileSaveName);
                }

                $excel2 = \PHPExcel_IOFactory::createReader(\PHPExcel_IOFactory::identify(public_path($fileSaveName)));
                $excel2 = $excel2->load(public_path($fileSaveName));
                $excel2->setActiveSheetIndex(0);

                echo "Gak ada watermark, mantull!!!: $file_ke | $fileSaveName | $item  <br>";
            }

            echo "baru File ke: " . $file_ke . " nih gan, sabar yakk, wkwkw : $file_ke | $fileSaveName | $item  <br>";

            if (ob_get_contents()) {
                ob_end_clean();
            }

            sleep(1);
            $file_ke++;
        }

        return "Udah selesai diupdate loh, wkwkwk";
    }

    public function setStatusExcel($status)
    {

    }
}
