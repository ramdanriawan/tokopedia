<?php

namespace App\Http\Livewire\Jabatan;

use App\Models\Jabatan;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class IndexTable extends Component
{
    public $data = [];

    public function render()
    {
        $this->index();

        return view('livewire.jabatan.index-table', $this->data);
    }

    public function index()
    {
        $this->data['jabatan'] = Jabatan::paginate(1000);

        $this->data['jabatan_count'] = count(Schema::getColumnListing('jabatan'));
    }

    public function destroy(Jabatan $jabatan)
    {
        // $jabatan->delete();

        session()->flash('success', 'Berhasil menghapus data jabatan.');
        
        $this->render();
    }

    public function hapus_semua(Request $request)
    {
        $jabatans = Jabatan::whereIn('id', json_decode($request->ids, true))->get();

        Jabatan::whereIn('id', $jabatans->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data jabatan');
    }
}
