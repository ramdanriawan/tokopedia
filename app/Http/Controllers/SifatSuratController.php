<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\SifatSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SifatSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['sifat_surat'] = SifatSurat::paginate(1000);

        $data['sifat_surat_count'] = count(Schema::getColumnListing('sifat_surat'));

        return view('sifat_surat.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('sifat_surat.create');
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
			'keterangan' => 'required|max:30'
		]);
        $requestData = $request->all();

        SifatSurat::create($requestData);

        return redirect()->route('sifat_surat.index')->with('success', 'Berhasil menambah sifat_surat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(SifatSurat $sifat_surat)
    {
        $data["item"] = $sifat_surat;
        $data["sifat_surat"] = $sifat_surat;

        return view('sifat_surat.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(SifatSurat $sifat_surat)
    {
        $data["sifat_surat"] = $sifat_surat;
        $data[strtolower("sifat_surat")] = $sifat_surat;

        return view('sifat_surat.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, SifatSurat $sifat_surat)
    {
        $this->validate($request, [
			'keterangan' => 'required|max:30'
		]);

        $requestData = $request->all();

        $sifat_surat->update($requestData);

        return redirect()->route('sifat_surat.index')->with('success', 'Berhasil mengubah sifat_surat');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(SifatSurat $sifat_surat)
    {
        $sifat_surat->delete();

        return redirect()->route('sifat_surat.index')->with('success', 'sifat_surat berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $sifat_surats = SifatSurat::whereIn('id', json_decode($request->ids, true))->get();

        SifatSurat::whereIn('id', $sifat_surats->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data sifat_surat');
    }

    public function laporan()
    {
        $data['limit'] = SifatSurat::count();

        return view('sifat_surat.laporan.index', $data);
    }

    public function print(Request $request)
    {
        $table = (new SifatSurat)->getTable();
        $object = (new SifatSurat);

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

        $data["sifat_surats"] = $object->orderBy($request->field, $request->order)->limit($request->limit)->get();

        if(!$data["sifat_surats"]->count()) {
            
            return back()->with('error', 'Data tidak ada!');
        }

        return view("sifat_surat.laporan.print", $data);
    }
}