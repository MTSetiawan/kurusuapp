<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Region;
use Illuminate\Http\Request;

class PublicListingController extends Controller
{
    public function Landing()
    {
        $listing = Listing::with('region')->where('status', 'active')->latest()->take(6)->get();
        return view('landing', ['listings' => $listing]);
    }

    public function show($slug, Region $region)
    {
        $listing = Listing::with(['region', 'user.teacherProfile'])
            ->where('slug', $slug)
            ->where('region_id', $region->id)
            ->where('status', 'active')
            ->firstOrFail();
        return view('listings.show', compact('listing'));
    }

    public function catalog(Request $request)
    {
        $region = Region::where('type', 'kecamatan')->oderBy('name')->get();

        $items = Listing::with('region')
            ->where('status', 'active')
            ->when($request->filled('region'), fn($q) => $q->where('region_id', $request->region))
            ->when($request->filled('category'), fn($q) => $q->where('category', 'like', '%' . $request->category . '%'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('catalog', [
            'items'   => $items,
            'regions' => $region,
            'filters' => $request->only('region', 'category'),
        ]);
    }
}
