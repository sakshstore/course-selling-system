<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
public function show()
{
return response()->json(Auth::user());
}

public function update(Request $request)
{
$request->validate([
'firstName' => 'required|string|max:255',
'middleName' => 'nullable|string|max:255',
'lastName' => 'required|string|max:255',
'dateOfBirth' => 'required|date',
'gender' => 'required|string|max:10',
'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
'phoneNumber' => 'required|string|max:20',
'street' => 'required|string|max:255',
'city' => 'required|string|max:255',
'state' => 'required|string|max:255',
'postalCode' => 'required|string|max:20',
'country' => 'required|string|max:255', 
'preferredLanguage' => 'required|string|max:50',
'specialAccommodations' => 'nullable|string|max:1000',
]);

$user = Auth::user();
$data = $request->only([
'firstName', 'middleName', 'lastName', 'dateOfBirth', 'gender', 'email', 'phoneNumber',
'street', 'city', 'state', 'postalCode', 'country', 'preferredLanguage', 'specialAccommodations'
]);

$user->update($data);

if ($request->hasFile('profilePicture')) {
// Delete old profile picture if exists
if ($user->profilePicture) {
Storage::delete($user->profilePicture);
}
// Store new profile picture
$data['profilePicture'] = $request->file('profilePicture')->store('profile_pictures');
}

$user->update($data);

return response()->json($data);
}
}