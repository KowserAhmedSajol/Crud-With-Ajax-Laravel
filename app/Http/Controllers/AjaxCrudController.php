<?php

namespace App\Http\Controllers;
use App\Models\AjaxCrud;
use Illuminate\Http\Request;

class AjaxCrudController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required',
        //     'address' => 'required',
        //     'image' => 'required',
        // ]);
        $user = new AjaxCrud;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid(). $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $user->image = $filename;
        }
        $user->save();
        return response()->json([
            'status' => 200
        ]);
    }

    public function fetchAll()
    {
        $users = AjaxCrud::orderBy('id', 'desc')->get();
        return response()->json($users);
    }

    public function edit(Request $request)
    {
        $user = AjaxCrud::find($request->id);
        return response()->json($user);
    }

    public function update(Request $request)
    {
        
        $user = AjaxCrud::find($request->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        if($request->hasFile('newimage')){
            $destination = public_path('images/'.$request->oldimage);
            if(file_exists($destination))
            {
                unlink($destination);
            }
            $file = $request->file('newimage');
            $filename = uniqid(). $file->getClientOriginalName();
            $file->move('images', $filename);
            $user->image = $filename;
        }else{
            $user->image = $request->oldimage;
        }

        $user->update();
        return response()->json([
            'status' => 200
        ]);
    }

    public function delete(Request $request)
    {
        $user = AjaxCrud::find($request->id);
        $image_path = public_path('images/'.$user->image);
        if(file_exists($image_path)) {
          unlink($image_path);
        }
        $user->delete();
    }

    public function search(Request $request)
    {
        $users = AjaxCrud::where('name', 'like', '%'.$request->search.'%')
                ->orderBy('id', 'desc')
                ->get();
    
       
        if($users->count()>=1){
            return response()->json($users);
        }else{
            return response()->json([
                'status' => 250
            ]);
        }
    }

}
