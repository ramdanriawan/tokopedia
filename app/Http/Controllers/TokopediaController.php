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
        $folderCekGambar  = glob('C:\Users\ramdan3mts\Documents\ubah-sekaligus-gambar\271386\*.xlsx');
        $folderUbahStatus = glob('C:\Users\ramdan3mts\Documents\ubah-sekaligus-status\271385\*.xlsx');

        // array_shift($folderCekGambar);
        // array_shift($folderUbahStatus);

        $folderKeBerapa = 1;
        foreach ($folderCekGambar as $keyFolder => $folderItem) { 

            // untuk skip karena sering gagal, jadi biar gk ngulang lagi gannnn
            // if($folderKeBerapa <= 1) continue;

            $file_excel = $folderItem;
            $worksheet  = \PHPExcel_IOFactory::createReaderForFile($file_excel)->load($file_excel)->getSheet(0);

            // update produk
            $excel2 = \PHPExcel_IOFactory::createReader(\PHPExcel_IOFactory::identify($folderUbahStatus[$keyFolder]));
            $excel2 = $excel2->load($folderUbahStatus[$keyFolder]);
            $excel2->setActiveSheetIndex(0);

            $gambar = [];
            $fileSaveName = 'tokopedia/file_update/TOKOPEDIA_PRODUCT_UPDATE_' . time() . '.xlsx';
            // $fileSaveName = 'TOKOPEDIA_PRODUCT_UPDATE_1612142048.xlsx';
            for ($row = 0; $row <= $worksheet->getHighestRow(); ++$row) {
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
                    echo "Ketemu nih produk yg gak ada watermarknya, mantulll <br>";

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
