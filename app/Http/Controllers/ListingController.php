<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all listings
    public function index() {
        return view('listings.index', [
            'listings' => Listing::filter(request(['tag', 'search']))->latest()->paginate(10),
        ]);
    }

    // Show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing,
        ]);
    }

    // Show create form
    public function create()
    {
        return view('listings.create');
    }

    // Store listing data 
    public function store(Request $request)
    {
        
        $formFileds = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFileds['logo'] = $request->file('logo')->store('logos', 'public');
            
        }

        $formFileds['user_id'] = auth()->id();

        Listing::create($formFileds);

        return redirect('/')->with('message', 'Listing Created Succcesfully');

        
    }

    // Show edit form
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update data
    public function update(Request $request, Listing $listing)
    {
        // Make sure that logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $formFileds = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFileds['logo'] = $request->file('logo')->store('logos', 'public');
            
        }

        $listing->update($formFileds);

        return back()->with('message', 'Listing Updated Successfully');
    }

    // Delete listing
    public function destroy(Listing $listing) {
        // Make sure that logged in user is owner
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $listing->delete();
        return redirect('/')->with('message', 'Listing Deleted Successfully');
    }

    // Manage listings view
    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
