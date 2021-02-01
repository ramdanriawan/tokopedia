<?php

namespace App\Http\Controllers;

use PHPExcel;
use App\Http\Requests;

use App\Models\Bagian;
use App\Models\SubBagian;
use App\Models\SuratKeluar;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SubBagianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['sub_bagian'] = SubBagian::paginate(1000);

        $data['sub_bagian_count'] = count(Schema::getColumnListing('sub_bagian'));

        return view('sub_bagian.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['bagian'] = Bagian::pluck('nama', 'id');

        return view('sub_bagian.create', $data);
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
			'bagian_id' => 'required|exists:bagian,id',
			'nama' => 'required|unique:sub_bagian,nama',
		]);
        $requestData = $request->all();

        

        SubBagian::create($requestData);

        return redirect()->route('bagian.show', $request->bagian_id)->with('success', 'Berhasil menambah SubBagian');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(SubBagian $sub_bagian)
    {
        $data["item"] = $sub_bagian;
        $data["sub_bagian"] = $sub_bagian;

        return view('sub_bagian.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(SubBagian $sub_bagian)
    {
        $data["sub_bagian"] = $sub_bagian;
        
        $data[strtolower("SubBagian")] = $sub_bagian;
        $data['bagian'] = Bagian::pluck('nama', 'id');

        return view('sub_bagian.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, SubBagian $sub_bagian)
    {
        $this->validate($request, [
            'bagian_id' => 'required|exists:bagian,id',
            'nama' => "required|unique:sub_bagian,nama,$request->nama,nama",
		]);

        $requestData = $request->all();

        

        $sub_bagian->update($requestData);

        return redirect()->route('bagian.show', $request->bagian_id)->with('success', 'Berhasil mengubah SubBagian');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(SubBagian $sub_bagian)
    {
        $sub_bagian->delete();

        return redirect()->back()->with('success', 'SubBagian berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $sub_bagians = SubBagian::whereIn('id', json_decode($request->ids, true))->get();

        SubBagian::whereIn('id', $sub_bagians->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data sub_bagian');
    }

    public function laporan()
    {

        return view('sub_bagian.laporan.index');
    }

    public function print(Request $request)
    {
        $table = (new SubBagian)->getTable();
        $object = (new SubBagian);

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

        $data["sub_bagians"] = $object->orderBy($request->field, $request->order)->limit($request->limit)->get();

        if(!$data["sub_bagians"]->count()) {
            
            return back()->with('error', 'Data tidak ada!');
        }

        // kalo user memilih print excel
        if ($request->print_excel) {

            return $this->print_excel($data["sub_bagians"]);
        }

        return view("sub_bagian.laporan.print", $data);
    }

    public function print_excel($data)
    {

        $PHPExcel        = new PHPExcel();
        $model           = new SubBagian();
        $sub_bagianTable = Arr::only(Schema::getColumnListing($model->getTable()), [1, 2]);

        // todo: mengisi data header ke baris excel
        $column = "A";
        foreach ($sub_bagianTable as $header => $sub_bagianHeader):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . 1, $sub_bagianHeader);
        endforeach;

        // isi ke excel
        $column = "A";
        $row    = 2;
        foreach ($data as $sub_bagian):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $sub_bagian->bagian->nama);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $sub_bagian->nama);

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