<?php
namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::all();
        return view('organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'public_key' => 'required',
            'private_key' => 'required',
        ]);

        Organization::create($data);

        return redirect()->route('organizations.index')->with('success', 'Organization created successfully');
    }

    public function show(Organization $organization)
    {
        return view('organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $data = $request->validate([
            'name' => 'required',
            'public_key' => 'required',
            'private_key' => 'required',
        ]);

        $organization->update($data);

        return redirect()->route('organizations.index')->with('success', 'Organization updated successfully');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()->route('organizations.index')->with('success', 'Organization deleted successfully');
    }
}
