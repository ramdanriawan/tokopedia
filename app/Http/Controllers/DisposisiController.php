<?php

namespace App\Http\Controllers;

use PHPExcel;
use App\Http\Requests;

use App\Models\Bagian;
use App\Models\Jabatan;
use App\Models\Disposisi;
use App\Models\UnitKerja;
use App\Models\SuratMasuk;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class DisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['disposisi'] = Disposisi::paginate(1000);

        if(request()->surat_masuk_id) {

            $data['disposisi'] = Disposisi::where('surat_masuk_id', request()->surat_masuk_id)->paginate(1000);
        }

        if(auth()->user()->level == 'Rekrutmen') {
            $data['disposisi'] = Disposisi::where('rekrutmen_jabatan_id', auth()->user()->rekrutmen->jabatan_id)->paginate(1000);
        }

        if(auth()->user()->level == 'Unit Kerja') {
            $data['disposisi'] = Disposisi::where('unit_kerja_sub_bagian_id', auth()->user()->unit_kerja->sub_bagian_id)->paginate(1000);
        }

        $data['disposisi_count'] = count(Schema::getColumnListing('disposisi'));

        return view('disposisi.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['bagians'] = Bagian::get();
        $data['rekrutmen_jabatans'] = Jabatan::pluck('nama', 'id')->toArray();
        $data['surat_masuk'] = SuratMasuk::findOrFail(request()->surat_masuk_id);

        return view('disposisi.create', $data);
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
			'surat_masuk_id' => 'required|exists:surat_masuk,id|unique:disposisi,surat_masuk_id',
			'waktu_disposisi' => 'required'
        ]);
        
        $requestData = $request->all();

        if(!$request->unit_kerja_sub_bagian_id && !$request->rekrutmen_jabatan_id) {

            return back()->with('error', 'Unit Kerja atau Jabatan wajib dipilih!');
        }

        Disposisi::create($requestData);

        return redirect()->route('surat_masuk.index')->with('success', 'Berhasil menambah Disposisi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(Disposisi $disposisi)
    {
        $data["item"] = $disposisi;
        $data["disposisi"] = $disposisi;

        return view('disposisi.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(Disposisi $disposisi)
    {
        $data["disposisi"] = $disposisi;
        $data[strtolower("Disposisi")] = $disposisi;

        $data['unit_kerja_sub_bagians'] = Bagian::pluck('nama', 'id')->toArray();
        $data['rekrutmen_jabatans'] = Jabatan::pluck('nama', 'id')->toArray();
        $data['surat_masuk'] = SuratMasuk::findOrFail(request()->surat_masuk_id);
        $data['bagians'] = Bagian::get();

        return view('disposisi.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Disposisi $disposisi)
    {
        $this->validate($request, [
			'surat_masuk_id' => "required|exists:surat_masuk,id|unique:disposisi,surat_masuk_id,$disposisi->surat_masuk_id,surat_masuk_id",
			'waktu_disposisi' => 'required'
        ]);

        $requestData = $request->all();

        if(!$request->unit_kerja_sub_bagian_id && !$request->rekrutmen_jabatan_id) {

            return back()->with('error', 'Unit Kerja atau Jabatan wajib dipilih!');
        }

        $disposisi->update($requestData);

        return redirect()->route('disposisi.index')->with('success', 'Berhasil mengubah Disposisi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Disposisi $disposisi)
    {
        $disposisi->delete();

        return redirect()->route('surat_masuk.index')->with('success', 'Disposisi berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $disposisis = Disposisi::whereIn('id', json_decode($request->ids, true))->get();

        Disposisi::whereIn('id', $disposisis->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data disposisi');
    }

    public function laporan()
    {
        $data['limit'] = Disposisi::count();
        $data['unit_kerja_sub_bagians'] = Bagian::all();
        $data['jabatans'] = Jabatan::all();

        return view('disposisi.laporan.index', $data);
    }

    public function print(Request $request)
    {
        $table = (new Disposisi)->getTable();
        $object = (new Disposisi);

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

        $data["disposisis"] = $object->orderBy($request->field, $request->order)
        ->whereBetween('waktu_disposisi', [$request->tanggal_awal, $request->tanggal_akhir])
        ->where('rekrutmen_jabatan_id', 'like', "%$request->rekrutmen_jabatan_id%")
        ->where('unit_kerja_sub_bagian_id', 'like', "%$request->user_unit_kerja_id%")
        ->limit($request->limit)->get();

        if(!$data["disposisis"]->count()) {
            
            return back()->with('error', 'Data tidak ada!');
        }

        // kalo user memilih print excel
        if ($request->print_excel) {

            return $this->print_excel($data["disposisis"]);
        }

        return view("disposisi.laporan.print", $data);
    }

    public function print_excel($data)
    {

        $PHPExcel        = new PHPExcel();
        $model           = new Disposisi();
        $disposisiTable = Arr::only(Schema::getColumnListing($model->getTable()), range(1, 4));

        // todo: mengisi data header ke baris excel
        $column = "A";
        foreach ($disposisiTable as $header => $disposisiHeader):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . 1, $disposisiHeader);
        endforeach;

        // isi ke excel
        $column = "A";
        $row    = 2;
        foreach ($data as $disposisi):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $disposisi->surat_masuk->perihal);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $disposisi->unit_kerja_sub_bagian->nama);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $disposisi->rekrutmen_jabatan->nama);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $disposisi->waktu_disposisi);

            $row++;
            $column = 'A';
        endforeach;

        // todo: memerintahkan browser untuk melakukan download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=print_excel_disposisi.xlsx");

        // todo: lakukan penulisan ke file excel
        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}