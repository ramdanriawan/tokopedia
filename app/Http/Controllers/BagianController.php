<?php

namespace App\Http\Controllers;

use PHPExcel;
use App\Http\Requests;

use App\Models\Bagian;
use App\Models\Jabatan;
use App\Models\SubBagian;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class BagianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        

        $data['bagian'] = Bagian::paginate(1000);

        $data['bagian_count'] = count(Schema::getColumnListing('bagian'));

        return view('bagian.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('bagian.create');
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
			'nama' => 'required|max:30'
		]);
        $requestData = $request->all();

        

        Bagian::create($requestData);

        return redirect()->route('bagian.index')->with('success', 'Berhasil menambah Bagian');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(Bagian $bagian)
    {
        $data["item"] = $bagian;
        $data["bagian"] = $bagian;
        
        $data['sub_bagian'] = SubBagian::paginate(1000);

        $data['sub_bagian_count'] = count(Schema::getColumnListing('sub_bagian'));

        return view('bagian.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(Bagian $bagian)
    {
        $data["bagian"] = $bagian;
        $data[strtolower("Bagian")] = $bagian;

        return view('bagian.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Bagian $bagian)
    {
        $this->validate($request, [
			'nama' => 'required|max:30'
		]);

        $requestData = $request->all();

        

        $bagian->update($requestData);

        return redirect()->route('bagian.index')->with('success', 'Berhasil mengubah Bagian');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Bagian $bagian)
    {
        $bagian->delete();

        return redirect()->route('bagian.index')->with('success', 'Bagian berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $bagians = Bagian::whereIn('id', json_decode($request->ids, true))->get();

        Bagian::whereIn('id', $bagians->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data bagian');
    }

    public function laporan()
    {
        $data['limit'] = Bagian::count();

        return view('bagian.laporan.index', $data);
    }

    public function print(Request $request)
    {
        $table = (new Bagian)->getTable();
        $object = (new Bagian);

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

        $data["bagians"] = $object->orderBy($request->field, $request->order)->limit($request->limit)->get();

        if(!$data["bagians"]->count()) {
            
            return back()->with('error', 'Data tidak ada!');
        }

        // kalo user memilih print excel
        if ($request->print_excel) {

            return $this->print_excel($data["bagians"]);
        }

        return view("bagian.laporan.print", $data);
    }

    public function print_excel($data)
    {

        $PHPExcel        = new PHPExcel();
        $model           = new Bagian();
        $bagianTable = Arr::only(Schema::getColumnListing($model->getTable()), range(1, 13));

        // todo: mengisi data header ke baris excel
        $column = "A";
        foreach ($bagianTable as $header => $bagianHeader):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . 1, $bagianHeader);
        endforeach;

        // isi ke excel
        $column = "A";
        $row    = 2;
        foreach ($data as $bagian):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $bagian->nama);

            $row++;
            $column = 'A';
        endforeach;

        // todo: memerintahkan browser untuk melakukan download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=print_excel_bagian.xlsx");

        // todo: lakukan penulisan ke file excel
        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }
}