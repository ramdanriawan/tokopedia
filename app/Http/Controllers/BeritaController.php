<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['berita'] = Berita::paginate(1000);

        $data['berita_count'] = count(Schema::getColumnListing('berita'));

        return view('berita.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('berita.create');
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
            'judul' => 'required|max:100',
            'gambar_depan' => 'required|mimes:png,jpg,jpeg',
            'isi'   => 'required',
        ]);

        $requestData = $request->all();

        if ($request->hasFile('gambar_depan')) {
            $requestData['gambar_depan'] = Storage::putFile(
                'public/images',
                $request->file('gambar_depan'));
        }

        if ($request->hasFile('lampiran')) {
            $requestData['lampiran'] = Storage::putFile(
                'public/images',
                $request->file('lampiran'));
        }

        Berita::create($requestData);

        return redirect()->route('berita.index')->with('success', 'Berhasil menambah Berita');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(Berita $berita)
    {
        $data["item"]   = $berita;
        $data["berita"] = $berita;

        return view('berita', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(Berita $berita)
    {
        $data["berita"]             = $berita;
        $data[strtolower("Berita")] = $berita;

        return view('berita.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Berita $berita)
    {
        $this->validate($request, [
            'judul'        => 'required|max:100',
            'isi'          => 'required',
        ]);

        $requestData = $request->all();

        if ($request->hasFile('gambar_depan')) {
            $requestData['gambar_depan'] = Storage::putFile(
                'public/images',
                $request->file('gambar_depan'));

            Storage::delete($berita->lampiran);
        }

        if ($request->hasFile('lampiran')) {
            $requestData['lampiran'] = Storage::putFile(
                'public/images',
                $request->file('lampiran'));

            Storage::delete($berita->lampiran);
        }

        $berita->update($requestData);

        return redirect()->route('berita.index')->with('success', 'Berhasil mengubah Berita');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Berita $berita)
    {
        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $beritas = Berita::whereIn('id', json_decode($request->ids, true))->get();

        Berita::whereIn('id', $beritas->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data berita');
    }

    public function laporan()
    {

        return view('berita.laporan.index');
    }

    function print(Request $request) {
        $table  = (new Berita)->getTable();
        $object = (new Berita);

        $fields = [];
        foreach (DB::select("DESC $table") as $tableField) {
            $fields[] = $tableField->Field;
        }

        $this->validate($request, [
            'field' => 'required|in:' . implode(',', $fields),
            'order' => 'required|in:ASC,DESC',
            'limit' => 'required|integer|max:' . $object->get()->count(),
        ]);

        $data["beritas"] = $object->orderBy($request->field, $request->order)->limit($request->limit)->get();

        if (!$data["beritas"]->count()) {

            return back()->with('error', 'Data tidak ada!');
        }

        return view("berita.laporan.print", $data);
    }
}
