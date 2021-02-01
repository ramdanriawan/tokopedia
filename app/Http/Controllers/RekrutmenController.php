<?php

namespace App\Http\Controllers;

use PHPExcel;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Rekrutmen;
use App\Models\SuratKeluar;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class RekrutmenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['rekrutmen'] = Rekrutmen::paginate(1000);

        $data['rekrutmen_count'] = count(Schema::getColumnListing('rekrutmen'));

        return view('rekrutmen.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['jabatans'] = Jabatan::pluck('nama', 'id');

        // $rekrutmens      = Rekrutmen::pluck('user_id')->toArray();
        // $data['users'] = User::where(['level' => 'Rekrutmen'])->whereNotIn('id', $rekrutmens)->pluck('name', 'id')->toArray();

        if (!$data['jabatans']) {
            return back()->with('error', 'Tidak ada data jabatan');
        }

        // if (!$data['users']) {
        //     return back()->with('error', 'Tidak ada data users level Rekrutmen yang bisa diberikan');
        // }

        return view('rekrutmen.create', $data);
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
            // 'user_id'       => 'required|exists:user,id',
            'jabatan_id'    => 'required|exists:jabatan,id',
            'nik'           => 'required|max:20',
            'nama'          => 'required|max:30',
            'tanggal_lahir' => 'required|max:12',
            'tempat_lahir'  => 'required|max:50',
            'jenis_kelamin' => 'required|in:Laki - Laki,Perempuan',
            'agama'         => 'required|in:Islam,Kristen Katolik,Kristen Protestan,Hindu,Budha',
            'alamat'        => 'required|max:255',
            'no_telepon'    => 'required|max:15|unique:rekrutmen,no_telepon',
            'status'        => 'required|in:PPK,PPS',
            'dibuat'        => 'required|max:12',
        ]);

        $requestData = $request->all();

        Rekrutmen::create($requestData);

        return redirect()->route('rekrutmen.index')->with('success', 'Berhasil menambah Rekrutmen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(Rekrutmen $rekrutmen)
    {
        $data["item"]    = $rekrutmen;
        $data["rekrutmen"] = $rekrutmen;

        

        return view('rekrutmen.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(Rekrutmen $rekrutmen)
    {
        $data["rekrutmen"]             = $rekrutmen;
        $data[strtolower("Rekrutmen")] = $rekrutmen;

        $data['jabatans'] = Jabatan::pluck('nama', 'id');

        // $rekrutmen_user_ids = Rekrutmen::where('user_id', 'not', $rekrutmen->user_id)->pluck('user_id')->toArray();
        // $data['users'] = User::where(['level' => 'Rekrutmen'])->whereNotIn('id', $rekrutmen_user_ids)->pluck('name', 'id')->toArray();

        if (!$data['jabatans']) {
            return back()->with('error', 'Tidak ada data jabatan');
        }

        // if (!$data['users']) {
        //     return back()->with('error', 'Tidak ada data users level Rekrutmen yang bisa diberikan');
        // }

        return view('rekrutmen.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Rekrutmen $rekrutmen)
    {
        $this->validate($request, [
            'jabatan_id'    => 'required|exists:jabatan,id',
            'nik'           => 'required|max:20',
            'nama'          => 'required|max:30',
            'tanggal_lahir' => 'required|max:12',
            'tempat_lahir'  => 'required|max:50',
            'jenis_kelamin' => 'required|in:Laki - Laki,Perempuan',
            'agama'         => 'required|in:Islam,Kristen Katolik,Kristen Protestan,Hindu,Budha',
            'alamat'        => 'required|max:255',
            'no_telepon'    => "required|max:15|unique:rekrutmen,no_telepon,$rekrutmen->no_telepon,no_telepon",
            'status'        => 'required|in:PPK,PPS',
            'dibuat'        => 'required|max:12',
        ]);

        $requestData = $request->all();

        $rekrutmen->update($requestData);

        return redirect()->route('rekrutmen.index')->with('success', 'Berhasil mengubah Rekrutmen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Rekrutmen $rekrutmen)
    {
        $rekrutmen->delete();

        return redirect()->route('rekrutmen.index')->with('success', 'Rekrutmen berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $rekrutmens = Rekrutmen::whereIn('id', json_decode($request->ids, true))->get();

        Rekrutmen::whereIn('id', $rekrutmens->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data rekrutmen');
    }

    public function laporan()
    {
        $data['limit'] = Rekrutmen::count();
        $data['jabatans'] = Jabatan::all();

        return view('rekrutmen.laporan.index', $data);
    }

    function print(Request $request) {
        $table  = (new Rekrutmen)->getTable();
        $object = (new Rekrutmen);

        $fields = [];
        foreach (DB::select("DESC $table") as $tableField) {
            $fields[] = $tableField->Field;
        }

        $this->validate($request, [
            'field' => 'required|in:' . implode(',', $fields),
            'order' => 'required|in:ASC,DESC',
            'limit' => 'required|integer|max:' . $object->get()->count(),
        ]);

        $data["rekrutmens"] = $object->orderBy($request->field, $request->order)
        ->whereBetween('dibuat', [$request->tanggal_awal, $request->tanggal_akhir])
        ->where('jabatan_id', 'like', "%$request->jabatan_id%")
        ->where('jenis_kelamin', 'like', "%$request->jenis_kelamin%")
        ->where('agama', 'like', "%$request->agama%")
        ->where('status', 'like', "%$request->status%")
        ->limit($request->limit)->get();

        if (!$data["rekrutmens"]->count()) {

            return back()->with('error', 'Data tidak ada!');
        }

        // kalo user memilih print excel
        if ($request->print_excel) {

            return $this->print_excel($data["rekrutmens"]);
        }

        return view("rekrutmen.laporan.print", $data);
    }

    public function print_excel($data)
    {

        $PHPExcel        = new PHPExcel();
        $model           = new Rekrutmen();
        $rekrutmenTable = Arr::only(Schema::getColumnListing($model->getTable()), range(1, 12));

        // todo: mengisi data header ke baris excel
        $column = "A";
        foreach ($rekrutmenTable as $header => $rekrutmenHeader):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . 1, $rekrutmenHeader);
        endforeach;

        // isi ke excel
        $column = "A";
        $row    = 2;
        foreach ($data as $rekrutmen):
            // $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->user->name);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->jabatan->nama);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->no_pendaftar);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->nik);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->nama);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->tanggal_lahir);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->tempat_lahir);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->jenis_kelamin);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->agama);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->alamat);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->no_telepon);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->status);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $rekrutmen->dibuat);

            $row++;
            $column = 'A';
        endforeach;

        // todo: memerintahkan browser untuk melakukan download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=print_excel_rekrutmen.xlsx");

        // todo: lakukan penulisan ke file excel
        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }
}
