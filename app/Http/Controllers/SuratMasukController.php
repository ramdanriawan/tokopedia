<?php

namespace App\Http\Controllers;

use PHPExcel;
use App\Models\Disposisi;
use App\Models\UnitKerja;
use App\Models\SifatSurat;
use App\Models\SuratMasuk;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['surat_masuk'] = SuratMasuk::paginate(1000);

        // kalo yang login unit kerja
        if (in_array(auth()->user()->level, ['Unit Kerja'])) {
            $data['surat_masuk'] = SuratMasuk::where('user_unit_kerja_id', auth()->user()->id)->paginate(1000);
        }

        if (request('status')) {
            $disposisi_surat_masuk_ids = Disposisi::pluck('surat_masuk_id')->toArray();

            $data['surat_masuk'] = $data['surat_masuk']->whereNotIn('id', $disposisi_surat_masuk_ids);
        }

        $data['surat_masuk_count'] = count(Schema::getColumnListing('surat_masuk'));

        return view('surat_masuk.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('surat_masuk.create');
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
            'waktu_masuk' => 'required|max:18',
            'nomor'       => 'required|max:30|unique:surat_masuk,nomor',
            'pengirim'    => 'required|max:30',
            'perihal'     => 'required|max:30',
            'isi_ringkas' => 'required|max:255',
            'lampiran'    => 'required',
        ]);

        $requestData                       = $request->all();
        $requestData['user_unit_kerja_id'] = auth()->user()->id;

        if ($request->hasFile('lampiran')) {
            $requestData['lampiran'] = Storage::putFile(
                'public/lampiran',
                $request->file('lampiran'));
        }

        SuratMasuk::create($requestData);

        return redirect()->route('surat_masuk.index')->with('success', 'Berhasil menambah SuratMasuk');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(SuratMasuk $surat_masuk)
    {
        $data["item"]        = $surat_masuk;
        $data["surat_masuk"] = $surat_masuk;

        return view('surat_masuk.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(SuratMasuk $surat_masuk)
    {
        $data["surat_masuk"]            = $surat_masuk;
        $data[strtolower("SuratMasuk")] = $surat_masuk;

        return view('surat_masuk.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, SuratMasuk $surat_masuk)
    {
        $this->validate($request, [
            'sifat_surat' => 'required|max:30',
            'waktu_masuk' => 'required|max:18',
            'nomor'       => "required|max:30|unique:surat_masuk,nomor,$surat_masuk->nomor,nomor",
            'pengirim'    => 'required|max:30',
            'perihal'     => 'required|max:30',
            'isi_ringkas' => 'required|max:255',
            'lampiran'    => '',
        ]);

        $requestData = $request->all();

        if ($request->hasFile('lampiran')) {
            $requestData['lampiran'] = Storage::putFile('public/images', $request->file('lampiran'));
            Storage::delete($surat_masuk->lampiran);
        }

        $surat_masuk->update($requestData);

        return redirect()->route('surat_masuk.index')->with('success', 'Berhasil mengubah SuratMasuk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(SuratMasuk $surat_masuk)
    {
        $surat_masuk->delete();

        return redirect()->route('surat_masuk.index')->with('success', 'SuratMasuk berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $surat_masuks = SuratMasuk::whereIn('id', json_decode($request->ids, true))->get();

        SuratMasuk::whereIn('id', $surat_masuks->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data surat_masuk');
    }

    public function laporan()
    {
        $data['limit']            = SuratMasuk::count();
        $data['sifat_surats']     = SuratMasuk::pluck('sifat_surat')->unique();
        $data['user_unit_kerjas'] = UnitKerja::all();

        return view('surat_masuk.laporan.index', $data);
    }

    function print(Request $request) {
        $table  = (new SuratMasuk)->getTable();
        $object = (new SuratMasuk);

        $fields = [];
        foreach (DB::select("DESC $table") as $tableField) {
            $fields[] = $tableField->Field;
        }

        $this->validate($request, [
            'field' => 'required|in:' . implode(',', $fields),
            'order' => 'required|in:ASC,DESC',
            'limit' => 'required|integer|max:' . $object->get()->count(),
        ]);

        $data["surat_masuks"] = $object->orderBy($request->field, $request->order)
            ->whereBetween('waktu_masuk', [$request->tanggal_awal, $request->tanggal_akhir])
            ->where('user_unit_kerja_id', 'like', "%$request->user_unit_kerja_id%")
            ->where('sifat_surat', 'like', "%$request->sifat_surat%")
            ->limit($request->limit)->get();

        if (!$data["surat_masuks"]->count()) {

            return back()->with('error', 'Data tidak ada!');
        }

        // kalo user memilih print excel
        if ($request->print_excel) {

            return $this->print_excel($data["surat_masuks"]);
        }

        return view("surat_masuk.laporan.print", $data);
    }

    public function print_excel($data)
    {

        $PHPExcel        = new PHPExcel();
        $model           = new SuratMasuk();
        $surat_masukTable = Arr::only(Schema::getColumnListing($model->getTable()), [1, 2, 3, 4, 5, 6, 7]);

        // todo: mengisi data header ke baris excel
        $column = "A";
        foreach ($surat_masukTable as $header => $surat_masukHeader):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . 1, $surat_masukHeader);
        endforeach;

        // isi ke excel
        $column = "A";
        $row    = 2;
        foreach ($data as $surat_masuk):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_masuk->sifat_surat);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_masuk->user_unit_kerja->name);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_masuk->waktu_masuk);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_masuk->nomor);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_masuk->pengirim);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_masuk->perihal);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $surat_masuk->isi_ringkas);

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
