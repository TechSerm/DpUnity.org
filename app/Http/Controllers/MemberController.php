<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Http\Requests\MemberUpdateRequest;
use App\Models\Member;
use App\Services\Image\ImageService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class MemberController extends Controller
{
    public function index()
    {
        return view('admin.member.index');
    }

    public function MemberData(Request $request)
    {
        $userQuery = Member::all();

        return DataTables::of($userQuery)
            ->filter(function ($query) use ($request) {})
            ->addColumn('photo', function ($model) {
                return "<img src='" . $model->image->src() . "' height='50px' width='50px' class='img-fluid img-thumbnail'>";
            })
            ->addColumn('approved', function ($model) {
                return $model->is_approved ? "<i style='color:green' class='fa fa-check'></i>" : "<i style='color:red' class='fa fa-times'></i>";
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format('j M Y, g:i A') . " (" . $model->created_at->diffForHumans() . ")";
            })
            ->editColumn('id', function ($model) {
                return $model->organization_id;
            })
            ->addColumn('action', function ($model) {
                $content = "<button data-url='" . route('admin.members.edit', ['member' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' data-modal-title='Update Member <b>#" . $model->id . "</b>'
                data-modal-size='650' data-toggle='modal'><i class='fa fa-edit'></i></button>";
                $content .= "<button data-url='" . route('admin.members.destroy', ['member' => $model->id]) . "' class='btn btn-danger btn-action btn-sm' data-callback='reloadProductDatatable()' data-toggle='delete'><i class='fa fa-trash'></i></button>";
                return $content;
            })

            ->make(true);
    }

    public function store(MemberRequest $request)
    {
        $imageId = null;
        $signatureId = null;

        if ($request->hasFile('image')) {
            $image = (new ImageService())->create('image');
            $imageId = $image ? $image->id : $imageId;
        }

        if ($request->hasFile('signature')) {
            $image = (new ImageService())->create('signature');
            $signatureId = $image ? $image->id : $signatureId;
        }

        Member::create([
            'name' => $request->input('name'),
            'father_name' => $request->input('father_name'),
            'mother_name' => $request->input('mother_name'),
            'date_of_birth' => $request->input('date_of_birth'),
            'nationality' => $request->input('nationality'),
            'religion' => $request->input('religion'),
            'present_address' => $request->input('present_address'),
            'permanent_address' => $request->input('permanent_address'),
            'occupation' => $request->input('occupation'),
            'nid' => $request->input('nid'),
            'mobile' => $request->input('mobile'),
            'blood_group' => $request->input('blood_group'),
            'image_id' => $imageId,
            'signature_id' => $signatureId,
            'user_id' => auth()->user()->id,
            'is_approved' => false
        ]);

        return response()->json([
            'message' => 'সদস্য সফলভাবে নিবন্ধিত হয়েছে!',
        ]);
    }

    public function edit(Member $member)
    {
        return view('admin.member.edit', compact('member'));
    }

    public function update(Member $member, MemberUpdateRequest $request)
    {

        $imageId = $member->image_id;
        $signatureId = $member->signature_id;

        if ($request->hasFile('image')) {
            $image = (new ImageService($member->image))->createAndReplace('image');
            $imageId = $image ? $image->id : $imageId;
        }

        if ($request->hasFile('signature')) {
            $image = (new ImageService($member->signature))->createAndReplace('signature');
            $signatureId = $image ? $image->id : $signatureId;
        }

        $member->update([
            'name' => $request->input('name'),
            'father_name' => $request->input('father_name'),
            'mother_name' => $request->input('mother_name'),
            'date_of_birth' => $request->input('date_of_birth'),
            'nationality' => $request->input('nationality'),
            'religion' => $request->input('religion'),
            'present_address' => $request->input('present_address'),
            'permanent_address' => $request->input('permanent_address'),
            'occupation' => $request->input('occupation'),
            'nid' => $request->input('nid'),
            'mobile' => $request->input('mobile'),
            'blood_group' => $request->input('blood_group'),
            'image_id' => $imageId,
            'signature_id' => $signatureId,
            'is_approved' => $request->input('is_approved'),
            'organization_id' => $request->input('organization_id'),
        ]);

        return response()->json([
            'message' => 'Member Successfully Updated'
        ]);
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json([
            'message' => 'Member Successfully Deleted'
        ]);
    }
    
    public function viewList()
    {
        $members = Member::where(['is_approved' => true])->orderBy('organization_id')->get();
        return view('member.list', compact('members'));
    }

    public function viewProfile($memberOrganizationId)
    {
        $member = Member::where(['organization_id' => $memberOrganizationId ,'is_approved' => true])->firstOrFail();

        return view('member.profile', compact('member'));
    }
}
