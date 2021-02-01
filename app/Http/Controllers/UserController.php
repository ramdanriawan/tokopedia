<?php

namespace App\Http\Controllers;

use PHPExcel;
use App\Models\User;

use App\Http\Requests;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
// FileUploader

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['user'] = User::paginate(1000);

        $data['user_count'] = count(Schema::getColumnListing('user'));

        return view('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user.create');
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
			'name' => 'required|string|max:30',
			'email' => 'required|email|max:50',
			'password' => 'required|max:100|confirmed',
			'password_confirmation' => 'required'
		]);
        $requestData = $request->all();

        

        User::create($requestData);

        return redirect()->route('user.index')->with('success', 'Berhasil menambah User');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $data["item"] = $user;
        $data["user"] = $user;

        return view('user.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $data["user"] = $user;
        $data[strtolower("User")] = $user;

        return view('user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
			'name' => 'required|string|max:30',
			'email' => 'required|email|max:50',
			'password' => 'required|max:100|confirmed',
			'password_confirmation' => 'required'
		]);

        $requestData = $request->all();

        $user->update($requestData);

        return redirect()->route('user.index')->with('success', 'Berhasil mengubah User');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $users = User::whereIn('id', json_decode($request->ids, true))->get();

        User::whereIn('id', $users->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data user');
    }

    public function laporan()
    {
        $data['limit'] = User::whereNotIn('level', ['Admin'])->count();

        return view('user.laporan.index', $data);
    }

    public function print(Request $request)
    {
        $table = (new User)->getTable();
        $object = (new User);

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

        $data["users"] = $object->orderBy($request->field, $request->order)
        // ->where('level', 'like', "%$request->level%")
        ->limit($request->limit)->get()->where('level', '!=', 'Admin');

        if(!$data["users"]->count()) {
            
            return back()->with('error', 'Data tidak ada!');
        }

        // kalo user memilih print excel
        if($request->print_excel) {
            
            return $this->print_excel($data["users"]);
        }

        return view("user.laporan.print", $data);
    }

    public function print_excel($data)
    {
        
        // todo: gunakan library PHPExcel
        $PHPExcel = new PHPExcel();

        // todo: mengambil isi header dari tabel users, cuman column kelas_id,nama,email
        $model = new User();
        $query = $model->query();

        $userTable = Arr::only(Schema::getColumnListing($model->getTable()), [1, 2, 4]);

        // todo: mengisi data header ke baris excel
        $column = "A";
        foreach ($userTable as $header => $userHeader):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . 1, $userHeader);
        endforeach;
        // isi ke excel
        $column = "A";
        $row    = 2;
        foreach ($data as $user):
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $user->name);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $user->email);
            $PHPExcel->setActiveSheetIndex(0)->setCellValue($column++ . $row, $user->level);

            $row++;
            $column = 'A';
        endforeach;

        // todo: memerintahkan browser untuk melakukan download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=print_excel_user.xlsx");

        // todo: lakukan penulisan ke file excel
        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function profile(User $user)
    {
        $data["user"] = $user;
        $data[strtolower("User")] = $user;

        return view('user.profile', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function profileUpdate(Request $request, User $user)
    {
        $this->validate($request, [
			'name' => 'required|string|max:30',
			'email' => 'required|email|max:50',
			'password' => 'required|max:100|confirmed',
			'password_confirmation' => 'required'
		]);

        $requestData = $request->all();

        $user->update($requestData);

        return redirect()->route('user.index')->with('success', 'Berhasil mengubah User');
    }
    
}