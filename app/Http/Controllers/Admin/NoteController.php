<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store(Request $request){
        $data=$request->validate([
            'user_id'=>'required|exists:users,id',
            'content'=>'required',
        ]);
        Note::create($data);
        return back()->with('success','تم إضافة الملاحظة بنجاح');
    }
    public function update(Request $request,Note $note){
        $data=$request->validate([
            'user_id'=>'required|exists:users,id',
            'content'=>'required',
        ]);
        $note->update($data);
        return back()->with('success','تم تعديل الملاحظة بنجاح');
    }
    public function destroy(Note $note){
        $note->delete();
        return back()->with('success','تم حذف الملاحظة بنجاح');
    }
}
