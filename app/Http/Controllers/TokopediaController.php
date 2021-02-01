<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

ini_set('max_execution_time', 0);
ob_start();

class TokopediaController extends Controller
{
    public function index()
    {
        
        $folderCekGambar  = preg_replace('/\\/', '/', glob(public_path('tokopedia\file_lama\271386\*.xlsx')));
        $folderUbahStatus = preg_replace('/\\/', '/', glob(public_path('tokopedia\file_lama\271385\*.xlsx')));
dd($folderCekGambar, $folderUbahStatus);
        // untuk membuat open link in new tab javascript
        if(!request()->file_ke && !request()->baris_ke) {
            for ($i=$_GET['start_dari']; $i < $_GET['berhenti_di']; $i++) { 
                
                echo "<script>window.open(\"?file_ke=$i&baris_ke=4\", \"_blank\"); </script>";
            }

            return false;
        }

        $folderKeBerapa = 1;
        for ($a = $_GET['file_ke']; $a < count($folderCekGambar); $a++) { 
            $file_excel = $folderCekGambar[$a];
            $worksheet  = \PHPExcel_IOFactory::createReaderForFile($file_excel)->load($file_excel)->getSheet(0);

            // update produk
            $excel2 = \PHPExcel_IOFactory::createReader(\PHPExcel_IOFactory::identify($folderUbahStatus[$a]));
            $excel2 = $excel2->load($folderUbahStatus[$a]);
            $excel2->setActiveSheetIndex(0);

            $gambar = [];
            $fileSaveName = 'tokopedia/file_update/TOKOPEDIA_PRODUCT_UPDATE_' . time() . '.xlsx';
            
            for ($row = $_GET['baris_ke']; $row <= $worksheet->getHighestRow(); ++$row) {
                $nomor = $row - 3;

                echo "Folder ke $folderKeBerapa, item ke $nomor <br>";
                if (ob_get_contents()) {
                    ob_end_clean();
                }

                $gambar[] = (string) $worksheet->getCell("L{$row}")->getValue();
                $gambar[] = (string) $worksheet->getCell("M{$row}")->getValue();
                $gambar[] = (string) $worksheet->getCell("N{$row}")->getValue();
                $gambar[] = (string) $worksheet->getCell("O{$row}")->getValue();
                $gambar[] = (string) $worksheet->getCell("P{$row}")->getValue();

                $gambarIniGakAdaWatermark = 0;
                foreach ($gambar as $key => $item) {

                    // kalo gambarnya gak ada ya g usah dicek
                    if(empty($item)) {
                        continue 1;
                    }

                    $data = [
                        'apikey'    => 'OCRK8154898A',
                        'url'       => $item,
                        'OCREngine' => 2,
                    ];

                    try {
                        $client = new \GuzzleHttp\Client();
                        $res    = $client->request('POST', "https://apipro3.ocr.space/parse/image", [
                            'form_params' => $data,
                        ]);

                        $ParsedResults = json_decode($res->getBody())->ParsedResults;

                        if (count($ParsedResults)) {

                            $ParsedText = $ParsedResults[0]->ParsedText;

                            if (empty($ParsedText)) {
                                $gambarIniGakAdaWatermark = 1;

                                break 1;
                            }
                        }
                    } catch (\Exception $e) {

                        exit($e->getMessage());
                    }
                }

                if($gambarIniGakAdaWatermark != 1) {
                    echo "Ketemu nih produk yg ada watermarknya, mantulll <br>";

                    $excel2->getActiveSheet()->setCellValue("I$row", 'Nonaktif');
                }

                $objWriter = \PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
                $objWriter->save($fileSaveName);
            }


            echo "baru folder ke: " . $folderKeBerapa . " nih gan, sabar yakk, wkwkw <br>";

            if (ob_get_contents()) {
                ob_end_clean();
            }

            sleep(1);
            $folderKeBerapa++;
        }

        return "Udah selesai diupdate loh, wkwkwk";
    }

    public function setStatusExcel($status)
    {

    }
}
