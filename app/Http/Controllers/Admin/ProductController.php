<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
{
    $products = $this->productService->getAll();
    return view('admin.products.index', compact('products'));
}

public function create()
{
    return view('admin.products.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    $this->productService->create($validated);

    return redirect()->route('admin.products.index')->with('success', 'Product added');
}

public function edit($id)
{
    $product = $this->productService->find($id);
    return view('admin.products.edit', compact('product'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    $this->productService->update($id, $validated);

    return redirect()->route('admin.products.index')->with('success', 'Updated');
}

public function destroy($id)
{
    $this->productService->delete($id);

    return redirect()->route('admin.products.index')
                     ->with('success', 'Product deleted');
}
}