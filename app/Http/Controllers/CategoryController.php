<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function data()
    {
        $category = Category::orderBy('id_category', 'desc')->get();

        return datatables()
            ->of($category)
            ->addIndexColumn()
            ->addColumn('action', function ($category) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('category.update', $category->id_category) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('category.destroy', $category->id_category) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $category = new category();
        $category->name_category = $request->name_category;
        $category->save();

        return response()->json('Data Submitted', 200);
    }

    public function show($id)
    {
        $category = Category::find($id);

        return response()->json($category);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name_category = $request->name_category;
        $category->update();

        return response()->json('Data Updated', 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return response(null, 204);
    }
}
