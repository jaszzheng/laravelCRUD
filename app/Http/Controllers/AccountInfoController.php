<?php

namespace App\Http\Controllers;

use App\Models\AccountInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
/**
 * Class AccountInfoController
 * @package App\Http\Controllers
 */
class AccountInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = AccountInfo::latest()->get();
            foreach ($data as $k => $v) {
                $day = explode('-', $v->birthday);
                $v->birthday = $day[0] . '年' . $day[1] . '月' . $day[2] . '日';
                if ($v->sex == 0) {
                    $v->sex = '女';
                }
                if ($v->sex == 1) {
                    $v->sex = '男';
                }
                $v->username = mb_strtolower($v->username);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editAccountInfo">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteAccountInfo">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('accountInfo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|max:255',
            'name' => 'required|max:255',
            'sex' => 'required',
            'birthday' => 'required|date',
            'email' => 'required|email:rfc,dns',
        ]);

        AccountInfo::updateOrCreate([
            'id' => $request->product_id
        ],
            [
                'username' => $request->username,
                'name' => $request->name,
                'sex' => $request->sex,
                'birthday' => $request->birthday,
                'email' => $request->email,
                'remark' => $request->remark
            ]);

        return response()->json(['success' => 'AccountInfo saved successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AccountInfo $AccountInfo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $AccountInfo = AccountInfo::find($id);
        return response()->json($AccountInfo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AccountInfo $AccountInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AccountInfo::find($id)->delete();

        return response()->json(['success' => 'AccountInfo deleted successfully.']);
    }

    /**
     * Batch delete.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function batchDelete(Request $request)
    {
        $ids = json_decode(stripslashes($request->data));;

        AccountInfo::whereIn('id', $ids)->delete();

        return response()->json(['success' => 'AccountInfo deleted successfully.']);
    }

    /**
     * Export to .txt.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function export(Request $request)
    {
        $ids = json_decode(stripslashes($request->data));

        $data = AccountInfo::whereIn('id', $ids)->get()->toArray();

        $file_name = 'a.txt';
        file_put_contents($file_name, $data);
        $file= public_path(). '/'. $file_name;

        $headers = array(
            'Content-Type: application/txt',
        );

        return response()->download($file, 'filename.txt', $headers);

    }
}
