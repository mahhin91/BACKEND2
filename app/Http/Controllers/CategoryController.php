<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\LogsExceptions;

class CategoryController extends Controller
{
    use LogsExceptions;

    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }
    public function store(Request $request)
    {
        try {
            $request->validate(['name' => 'required']);
            Category::create(['name' => $request->name]);
            return redirect()->route('categories');
        } catch (\Exception $e) {
            $this->logException($e, 'CategoryController@store');
            return redirect()->back()->withErrors('Có lỗi xảy ra khi tạo danh mục.');
        }
    }

    public function delete($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->route('categories');
        } catch (\Exception $e) {
            $this->logException($e, 'CategoryController@delete');
            return redirect()->back()->withErrors('Có lỗi xảy ra khi xóa danh mục.');
        }
    }
}
