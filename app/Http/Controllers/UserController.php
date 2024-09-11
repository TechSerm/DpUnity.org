<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Image\ImageService;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'dataRoute' => route('admin.admin_users.data')
        ]);
    }

    public function normalUser()
    {
        return view('users.index', [
            'dataRoute' => route('admin.normal_users.data')
        ]);
    }

    public function getAdminData(Request $request)
    {
        $userQuery = User::where(['role_name' => 'admin']);

        return DataTables::of($userQuery)
            ->filter(function ($query) use ($request) {})
            ->addColumn('action', function ($model) {
                $content = "<button data-url='" . route('admin.users.edit', ['user' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' data-modal-title='Update User <b>#" . $model->id . "</b>'
                data-modal-size='650' data-toggle='modal'><i class='fa fa-edit'></i></button>";
                return $content;
            })
            ->make(true);
    }

    public function getNormalUserData(Request $request)
    {
        $userQuery = User::where(['role_name' => 'user']);

        return DataTables::of($userQuery)
            ->filter(function ($query) use ($request) {})
            ->addColumn('action', function ($model) {
                $content = "<button data-url='" . route('admin.users.edit', ['user' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' data-modal-title='Update User <b>#" . $model->id . "</b>'
                data-modal-size='650' data-toggle='modal'><i class='fa fa-edit'></i></button>";
                return $content;
            })
            ->make(true);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/(01)[0-9]{9}/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        $imageId = null;

        if ($request->hasFile('image')) {
            $image = $this->getImageService((new ImageService()))->create('image');
            $imageId = $image ? $image->id : $imageId;
        }

        $user = new User();

        $user->image_id = $imageId;

        $user->password = bcrypt($request->password);
        $user->role_name = "admin";

        $user->fill($request->all())->save();

        return back()->with('success', 'User created successfully!');
    }

    private function getImageService($imgSrv)
    {
        return $imgSrv->setText("");
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate(request(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/(01)[0-9]{9}/'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'password' => ['nullable', 'string', 'confirmed'],
            'role_name' => ['required']
        ]);

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }


        $user->fill($request->except(['password', 'password_confirmation']))->save();

        return response()->json([
            'message' => 'User Successfully Updated'
        ]);
    }

    public function show()
    {
        abort(404);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->imageSrv()->delete();
        $user->delete();
    }
}
