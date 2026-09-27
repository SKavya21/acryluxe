<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:255',
            'sizes' => 'required|array|min:1',
            'sizes.*.size' => 'nullable|string|max:255',
            'sizes.*.quantity' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['sizes'] = $this->normalizeSizes($validated['sizes']);
        if (empty($validated['sizes'])) {
            return back()->withErrors(['sizes' => 'Add at least one product size.'])->withInput();
        }

        if ($request->hasFile('images')) {
            $validated['images'] = collect($request->file('images'))
                ->map(fn ($image) => $image->store('products', 'public'))
                ->values()
                ->all();
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:255',
            'sizes' => 'required|array|min:1',
            'sizes.*.size' => 'nullable|string|max:255',
            'sizes.*.quantity' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'string',
        ]);

        $validated['sizes'] = $this->normalizeSizes($validated['sizes']);
        if (empty($validated['sizes'])) {
            return back()->withErrors(['sizes' => 'Add at least one product size.'])->withInput();
        }

        $product = $this->productService->find($id);
        $currentImages = $product->imagePaths();
        $imagesToDelete = array_values(array_intersect($currentImages, $validated['delete_images'] ?? []));

        foreach ($imagesToDelete as $image) {
            Storage::disk('public')->delete($image);
        }

        $remainingImages = array_values(array_diff($currentImages, $imagesToDelete));
        $newImages = $request->hasFile('images')
            ? collect($request->file('images'))->map(fn ($image) => $image->store('products', 'public'))->values()->all()
            : [];

        $validated['images'] = array_values(array_unique(array_merge($remainingImages, $newImages)));
        $validated['image'] = $validated['images'][0] ?? null;
        unset($validated['delete_images']);

        $this->productService->update($id, $validated);

        return redirect()->route('admin.products.index')->with('success', 'Updated');
    }

    public function deleteImage(Request $request, Product $product)
    {
        $validated = $request->validate([
            'image' => ['required', 'string'],
        ]);

        $currentImages = $product->imagePaths();
        if (! in_array($validated['image'], $currentImages, true)) {
            return response()->json(['message' => 'Photo not found.'], 404);
        }

        Storage::disk('public')->delete($validated['image']);
        $remainingImages = array_values(array_diff($currentImages, [$validated['image']]));
        $product->update([
            'images' => $remainingImages,
            'image' => $remainingImages[0] ?? null,
        ]);

        return response()->json(['message' => 'Photo deleted successfully.']);
    }

    public function destroy($id)
    {
        $product = $this->productService->find($id);
        foreach ($product->imagePaths() as $image) {
            Storage::disk('public')->delete($image);
        }

        $this->productService->delete($id);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted');
    }

    private function normalizeSizes(array $sizeRows): array
    {
        $sizes = [];

        foreach ($sizeRows as $row) {
            $size = trim((string) ($row['size'] ?? ''));
            if ($size === '') {
                continue;
            }

            $sizes[$size] = max(0, (int) ($row['quantity'] ?? 0));
        }

        return $sizes;
    }
}