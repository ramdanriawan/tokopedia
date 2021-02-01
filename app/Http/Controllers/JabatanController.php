<?php

namespace App\Http\Controllers;

use PHPExcel;
use App\Http\Requests;

use App\Models\Jabatan;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['jabatan'] = Jabatan::paginate(1000);

        $data['jabatan_count'] = count(Schema::getColumnListing('jabatan'));

        return view('jabatan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('jabatan.create');
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

        

        Jabatan::create($requestData);

        return redirect()->route('jabatan.index')->with('success', 'Berhasil menambah Jabatan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(Jabatan $jabatan)
    {
        $data["item"] = $jabatan;
        $data["jabatan"] = $jabatan;

        return view('jabatan.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(Jabatan $jabatan)
    {
        $data["jabatan"] = $jabatan;
        $data[strtolower("Jabatan")] = $jabatan;

        return view('jabatan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $this->validate($request, [
			'nama' => 'required|max:30'
		]);

        $requestData = $request->all();

        

        $jabatan->update($requestData);

        return redirect()->route('jabatan.index')->with('success', 'Berhasil mengubah Jabatan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $jabatans = Jabatan::whereIn('id', json_decode($request->ids, true))->get();

        Jabatan::whereIn('id', $jabatans->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data jabatan');
    }

    public function laporan()
    {
        $data['limit'] = Jabatan::count();

        return view('jabatan.laporan.index', $data);
    }

    public function print(Request $request)
    {
        $table = (new Jabatan)->getTable();
        $object = (new Jabatan);

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

        $data["jabatans"] = $object->orderBy($request->field, $request->order)->limit($request->limit)->get();

        if(!$data["jabatans"]->count()) {
            
            return back()->with('error', 'Data tidak ada!');
        }

        // kalo user memilih print excel
        if ($request->print_excel) {

            return $this->print_excel($data["jabatans"]);
        }

        return view("jabatan.laporan.print", $data);
    }

    public function print_excel($data)
    {

        $PHPExcel        = new PHPExcel();
        $model           = new Jabatan();
        $jabatanTable = Arr::only(Schema::getColumnListing($model->getTable()), range(1, 13));

        // todo: mengisi data header ke baris excel
        $column = "A";
        foreach ($jabatanTable as $header => $jabatanHeader):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . 1, $jabatanHeader);
        endforeach;

        // isi ke excel
        $column = "A";
        $row    = 2;
        foreach ($data as $jabatan):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $jabatan->nama);

            $row++;
            $column = 'A';
        endforeach;

        // todo: memerintahkan browser untuk melakukan download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=print_excel_jabatan.xlsx");

        // todo: lakukan penulisan ke file excel
        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }
}