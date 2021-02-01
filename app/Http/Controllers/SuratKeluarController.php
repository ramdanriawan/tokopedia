<?php

namespace App\Http\Controllers;

use PHPExcel;
use App\Http\Requests;

use App\Models\UnitKerja;
use App\Models\SifatSurat;
use App\Models\SuratKeluar;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['surat_keluar'] = SuratKeluar::paginate(1000);

        $data['surat_keluar_count'] = count(Schema::getColumnListing('surat_keluar'));

        return view('surat_keluar.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('surat_keluar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'sifat_surat' => 'required|max:30',
			'waktu_keluar' => 'required|max:18',
			'nomor' => "required|max:30|unique:surat_masuk,nomor",
			'pengirim' => 'required|max:30',
			'perihal' => 'required|max:30',
			'kepada' => 'required|max:30',
			'bagian' => 'required|max:30',
			'isi_ringkas' => 'required|max:255',
			'lampiran' => 'required'
        ]);
        
        $requestData = $request->all();
        $requestData['user_unit_kerja_id'] = auth()->user()->id;

                if ($request->hasFile('lampiran')) {
            $requestData['lampiran'] = Storage::putFile(
                'public/lampiran',
                $request->file('lampiran'));
        }

        SuratKeluar::create($requestData);

        return redirect()->route('surat_keluar.index')->with('success', 'Berhasil menambah SuratKeluar');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(SuratKeluar $surat_keluar)
    {
        $data["item"] = $surat_keluar;
        $data["surat_keluar"] = $surat_keluar;

        return view('surat_keluar.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(SuratKeluar $surat_keluar)
    {
        $data["surat_keluar"] = $surat_keluar;
        $data[strtolower("SuratKeluar")] = $surat_keluar;
        $data['sifat_surats'] = SuratKeluar::pluck('sifat_surat')->toArray();

        return view('surat_keluar.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, SuratKeluar $surat_keluar)
    {
        $this->validate($request, [
			'sifat_surat' => 'required|max:30',
			'waktu_keluar' => 'required|max:18',
			'nomor' => "required|max:30|unique:surat_keluar,nomor,$surat_keluar->nomor,nomor",
			'pengirim' => 'required|max:30',
			'perihal' => 'required|max:30',
			'kepada' => 'required|max:30',
			'bagian' => 'required|max:30',
			'isi_ringkas' => 'required|max:255'
		]);

        $requestData = $request->all();

                if ($request->hasFile('lampiran')) {
            $requestData['lampiran'] = Storage::putFile(
                'public/lampiran',
                $request->file('lampiran')); 
                Storage::delete($surat_keluar->lampiran);
        }


        $surat_keluar->update($requestData);

        return redirect()->route('surat_keluar.index')->with('success', 'Berhasil mengubah SuratKeluar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(SuratKeluar $surat_keluar)
    {
        $surat_keluar->delete();

        return redirect()->route('surat_keluar.index')->with('success', 'SuratKeluar berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $surat_keluars = SuratKeluar::whereIn('id', json_decode($request->ids, true))->get();

        SuratKeluar::whereIn('id', $surat_keluars->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data surat_keluar');
    }

    public function laporan()
    {
        $data['limit'] = SuratKeluar::count();
        $data['sifat_surats'] = SuratKeluar::pluck('sifat_surat')->unique();
        $data['user_unit_kerjas'] = UnitKerja::all();

        return view('surat_keluar.laporan.index', $data);
    }

    public function print(Request $request)
    {
        $table = (new SuratKeluar)->getTable();
        $object = (new SuratKeluar);

        $fields = [];
        foreach(DB::select("DESC $table") as $tableField)
        {
            $fields[] = $tableField->Field;
        }

        $this->validate($request, [
            'field' => 'required|in:' . implode(',', $fields),
            'order' => 'required|in:ASC,DESC',
            'limit' => 'required|integer|max:' . $object->get()->count(),
        ]);

        $data["surat_keluars"] = $object->orderBy($request->field, $request->order)
        ->whereBetween('waktu_keluar', [$request->tanggal_awal, $request->tanggal_akhir])
        ->where('user_unit_kerja_id', 'like', "%$request->user_unit_kerja_id%")
        ->where('sifat_surat', 'like', "%$request->sifat_surat%")
        ->limit($request->limit)->get();

        if(!$data["surat_keluars"]->count()) {
            
            return back()->with('error', 'Data tidak ada!');
        }

        // kalo user memilih print excel
        if ($request->print_excel) {

            return $this->print_excel($data["surat_keluars"]);
        }

        return view("surat_keluar.laporan.print", $data);
    }

    public function print_excel($data)
    {

        $PHPExcel        = new PHPExcel();
        $model           = new SuratKeluar();
        $surat_keluarTable = Arr::only(Schema::getColumnListing($model->getTable()), range(1, 9));

        // todo: mengisi data header ke baris excel
        $column = "A";
        foreach ($surat_keluarTable as $header => $surat_keluarHeader):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . 1, $surat_keluarHeader);
        endforeach;

        // isi ke excel
        $column = "A";
        $row    = 2;
        foreach ($data as $surat_keluar):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_keluar->sifat_surat);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_keluar->user_unit_kerja->name);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_keluar->waktu_keluar);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_keluar->nomor);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_keluar->pengirim);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_keluar->perihal);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_keluar->kepada);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_keluar->bagian);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_keluar->isi_ringkas);

            $row++;
            $column = 'A';
        endforeach;

        // todo: memerintahkan browser untuk melakukan download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=print_excel_surat_masuk.xlsx");

        // todo: lakukan penulisan ke file excel
        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }
}