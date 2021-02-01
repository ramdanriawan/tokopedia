<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bagian;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use PHPExcel;

class UnitKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['unit_kerja'] = UnitKerja::paginate(1000);

        $data['unit_kerja_count'] = count(Schema::getColumnListing('unit_kerja'));

        return view('unit_kerja.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['bagians'] = Bagian::get();

        $unit_kerja_user_ids = UnitKerja::pluck('user_id')->toArray();
        $data['users']       = User::where(['level' => 'Unit Kerja'])->whereNotIn('id', $unit_kerja_user_ids)->pluck('name', 'id')->toArray();

        if (!$data['bagians']) {
            return back()->with('error', 'Tidak ada data bagian');
        }

        if (!$data['users']) {
            return back()->with('error', 'Tidak ada data users level Unit Kerja yang bisa diberikan');
        }

        return view('unit_kerja.create', $data);
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
            'sub_bagian_id'     => 'required|exists:sub_bagian,id',
            'nama'          => 'required|max:30',
            'jenis_kelamin' => 'required|in:Laki - Laki,Perempuan',
            'alamat'        => 'required|max:255',
            'no_telepon'    => 'required|max:15|unique:unit_kerja,no_telepon',
            'status'        => 'required|in:Aktif,Tidak Aktif',
            'dibuat'        => 'required|max:12',
        ]);
        $requestData = $request->all();

        UnitKerja::create($requestData);

        return redirect()->route('unit_kerja.index')->with('success', 'Berhasil menambah UnitKerja');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(UnitKerja $unit_kerja)
    {
        $data["item"]       = $unit_kerja;
        $data["unit_kerja"] = $unit_kerja;

        return view('unit_kerja.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(UnitKerja $unit_kerja)
    {
        $data['bagians'] = Bagian::get();
        $unit_kerja_user_ids = UnitKerja::where('user_id', 'not', $unit_kerja->user_id)->pluck('user_id')->toArray();
        $data['users']       = User::where(['level' => 'Unit Kerja'])->whereNotIn('id', $unit_kerja_user_ids)->pluck('name', 'id')->toArray();

        if (!$data['bagians']) {
            return back()->with('error', 'Tidak ada data bagian');
        }

        if (!$data['users']) {
            return back()->with('error', 'Tidak ada data users level Unit Kerja yang bisa diberikan');
        }

        $data[strtolower("unit_kerja")] = $unit_kerja;

        return view('unit_kerja.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, UnitKerja $unit_kerja)
    {
        $this->validate($request, [
            'sub_bagian_id'     => 'required|exists:sub_bagian,id',
            'nama'          => 'required|max:30',
            'jenis_kelamin' => 'required|in:Laki - Laki,Perempuan',
            'alamat'        => 'required|max:255',
            'no_telepon'    => "required|max:15|unique:unit_kerja,no_telepon,$unit_kerja->no_telepon,no_telepon",
            'status'        => 'required|in:Aktif,Tidak Aktif',
            'dibuat'        => 'required|max:12',
        ]);

        $requestData = $request->all();

        $unit_kerja->update($requestData);

        return redirect()->route('unit_kerja.index')->with('success', 'Berhasil mengubah UnitKerja');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(UnitKerja $unit_kerja)
    {
        $unit_kerja->delete();

        return redirect()->route('unit_kerja.index')->with('success', 'UnitKerja berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $unit_kerjas = UnitKerja::whereIn('id', json_decode($request->ids, true))->get();

        UnitKerja::whereIn('id', $unit_kerjas->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data unit_kerja');
    }

    public function laporan()
    {
        $data['limit']   = UnitKerja::count();
        $data['bagians'] = Bagian::all();

        return view('unit_kerja.laporan.index', $data);
    }

    function print(Request $request) {
        $table  = (new UnitKerja)->getTable();
        $object = (new UnitKerja);

        $fields = [];
        foreach (DB::select("DESC $table") as $tableField) {
            $fields[] = $tableField->Field;
        }

        $this->validate($request, [
            'field' => 'required|in:' . implode(',', $fields),
            'order' => 'required|in:ASC,DESC',
            'limit' => 'required|integer|max:' . $object->get()->count(),
        ]);

        $data["unit_kerjas"] = $object->orderBy($request->field, $request->order)
            ->whereBetween('dibuat', [$request->tanggal_awal, $request->tanggal_akhir])
            ->where('sub_bagian_id', 'like', "%$request->sub_bagian_id%")
            ->where('jenis_kelamin', 'like', "%$request->jenis_kelamin%")
            ->where('status', 'like', "%$request->status%")
            ->limit($request->limit)->get();
        
        if(!$data["unit_kerjas"]->count()) {
        
            return back()->with('error', 'Data tidak ada!');
        }

        // kalo user memilih print excel
        if ($request->print_excel) {

            return $this->print_excel($data["unit_kerjas"]);
        }

        return view("unit_kerja.laporan.print", $data);
    }

    public function print_excel($data)
    {

        $PHPExcel  = new PHPExcel();
        $model     = new UnitKerja();
        $unit_kerjaTable = Arr::only(Schema::getColumnListing($model->getTable()), [1, 2, 3, 4, 5, 6, 7, 8]);

        // todo: mengisi data header ke baris excel
        $column = "A";
        foreach ($unit_kerjaTable as $header => $unit_kerjaHeader):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . 1, $unit_kerjaHeader);
        endforeach;

        // isi ke excel
        $column = "A";
        $row    = 2;
        foreach ($data as $unit_kerja):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $unit_kerja->user->name);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $unit_kerja->sub_bagian->nama);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $unit_kerja->nama);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $unit_kerja->jenis_kelamin);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $unit_kerja->alamat);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $unit_kerja->no_telepon);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $unit_kerja->status);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $unit_kerja->dibuat);

            $row++;
            $column = 'A';
        endforeach;

        // todo: memerintahkan browser untuk melakukan download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=print_excel_unit_kerja.xlsx");

        // todo: lakukan penulisan ke file excel
        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }
}
