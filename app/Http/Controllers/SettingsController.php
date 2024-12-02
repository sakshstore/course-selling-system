<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Add this line



class SettingsController extends Controller
{
public function getCurrencySymbol()
{
return response()->json(['value' => config('settings.currency_symbol')]);
}






public function update(Request $request)
{
$request->validate([
'currency_symbol' => 'required|string|max:5',
]);

$this->updateConfigFile('settings', [
'currency_symbol' => $request->currency_symbol,
]);

return response()->json(['message' => 'Settings updated successfully']);
}

 

public function updateSettings(Request $request)
{
$request->validate([
'currency_symbol' => 'required|string|max:5',
]);

$this->updateConfigFile('settings', [
'currency_symbol' => $request->currency_symbol,
]);

return response()->json(['message' => 'Settings updated successfully']);
}

private function updateConfigFile($file, $data)
{
$path = config_path($file . '.php');
$config = include $path;

$newConfig = array_merge($config, $data);

$content = '<?php return ' . var_export($newConfig, true) . ';';
File::put($path, $content);
}



}
