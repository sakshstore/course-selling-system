<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

 




class SettingsController extends Controller
{
    public function getCurrencySymbol()
    {
        return response()->json(['value' => config('settings.currency_symbol')]);
    }

    public function getBrandSettings()
    {
        return response()->json([
            'companyName' => config('settings.company_name'),
         
           'email' => config('settings.email'),
            'phoneNumber' => config('settings.phone_number'),
            'whatsapp' => config('settings.whatsapp'),
            'instagram' => config('settings.instagram'),
            'twitter' => config('settings.twitter'),
            'facebook' => config('settings.facebook'),
            'youtube' => config('settings.youtube'),
            'snapchat' => config('settings.snapchat'),
            'footerText' => config('settings.footerText'),
            'welcomeText' => config('settings.welcomeText'),
            'supportText' => config('settings.supportText'),
            'currency_symbol' => config('settings.currency_symbol'),
        ]);
    }

    public function saveBrandSettings(Request $request)
    {
        $this->validateBrandSettings($request);

       

        $this->updateConfigFile('settings', [
         //   'company_name' => $request->companyName,
           // 'company_logo' => $companyLogo,
         
            'email' => $request->email,
            'phone_number' => $request->phoneNumber,
            'whatsapp' => $request->whatsapp,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'facebook' => $request->facebook,
            'youtube' => $request->youtube,
            'snapchat' => $request->snapchat,
            'currency_symbol' => $request->currency_symbol,
        ]);

        return response()->json(['message' => 'Settings updated successfully']);
    }

    public function updateCurrencySymbol(Request $request)
    {
        $request->validate([
            'currency_symbol' => 'required|string|max:5',
        ]);

        $this->updateConfigFile('settings', [
            'currency_symbol' => $request->currency_symbol,
        ]);

        return response()->json(['message' => 'Currency symbol updated successfully']);
    }

    public function getSectionsText()
    {
        return response()->json([
            'footerText' => config('settings.footerText'),
            'welcomeText' => config('settings.welcomeText'),
            'supportText' => config('settings.supportText'),
        ]);
    }

    public function postSectionsText(Request $request)
    {
        $request->validate([
            'footerText' => 'required|string',
            'welcomeText' => 'required|string',
            'supportText' => 'required|string',
        ]);

        $this->updateConfigFile('settings', [
            'footerText' => $request->footerText,
            'welcomeText' => $request->welcomeText,
            'supportText' => $request->supportText,
        ]);

        return response()->json(['message' => 'Updated successfully']);
    }

    public function getSMTP()
    {
        $settings = [
            'host' => env('MAIL_HOST'),
            'port' => env('MAIL_PORT'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'encryption' => env('MAIL_ENCRYPTION'),
        ];

        return response()->json($settings);
    }

    public function saveSMTP(Request $request)
    {
        $this->validateSMTPSettings($request);

        $settings = [
            'MAIL_HOST' => $request->host,
            'MAIL_PORT' => $request->port,
            'MAIL_USERNAME' => $request->username,
            'MAIL_PASSWORD' => $request->password,
            'MAIL_ENCRYPTION' => $request->encryption,
        ];

        foreach ($settings as $key => $value) {
            $this->setEnvironmentValue($key, $value);
        }

        Artisan::call('config:cache');

        return response()->json(['message' => 'SMTP settings saved successfully.']);
    }

    public function testSmtpSettings(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            Mail::raw('This is a test email to verify SMTP settings.', function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Test SMTP Settings');
            });

            return response()->json(['message' => 'Test email sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send test email: ' . $e->getMessage()], 500);
        }
    }

    public function getTextSettings()
    {
        return response()->json([
            'footerText' => config('settings.footer_text'),
            'welcomeText' => config('settings.welcome_text'),
            'supportText' => config('settings.support_text'),
        ]);
    }

    public function saveTextSettings(Request $request)
    {
        $request->validate([
            'footerText' => 'required|string',
            'welcomeText' => 'required|string',
            'supportText' => 'required|string',
        ]);

        $this->updateConfigFile('settings', [
            'footer_text' => $request->footerText,
            'welcome_text' => $request->welcomeText,
            'support_text' => $request->supportText,
        ]);

        return response()->json(['message' => 'Text settings updated successfully']);
    }

    public function getApikeySettings()
    {
        return response()->json([
            'provider' => config('settings.api_provider'),
            'openaiKey' => config('settings.openai_key'),
            'googleGeminieKey' => config('settings.google_geminie_key'),
        ]);
    }

    public function saveApikeySettings(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'openaiKey' => 'nullable|string',
            'googleGeminieKey' => 'nullable|string',
        ]);

        $this->updateConfigFile('settings', [
            'api_provider' => $request->provider,
            'openai_key' => $request->openaiKey,
            'google_geminie_key' => $request->googleGeminieKey,
        ]);

        return response()->json(['message' => 'API settings saved successfully!']);
    }

    public function saveloginBanner(Request $request)
    {
        $request->validate([
            'loginBanner' => 'required|image|max:2048', // Validate image
        ]);

        $loginBanner = $this->saveImage($request->file('loginBanner'), 'login_banner');

        return response()->json([

            'loginBanner' => $loginBanner,
            'message' => 'Images uploaded successfully',
        ]);
    }

    public function savecompanyLogo(Request $request)
    {
        $request->validate([
            'companyLogo' => 'required|image|max:2048',
        ]);

        $companyLogo = $this->saveImage($request->file('companyLogo'), 'company_logo');

        return response()->json([
            'companyLogo' => $companyLogo,

            'message' => 'Images uploaded successfully',
        ]);
    }

    private function saveImage($image, $type)
    {
        if ($image) {
            $path = $image->store('public/images');
            return Storage::url($path);
        }
        return config("settings.$type");
    }

    private function updateConfigFile($file, $data)
    {
        $path = config_path($file . '.php');
        $config = include $path;

        $newConfig = array_merge($config, $data);

        $content = '<?php return ' . var_export($newConfig, true) . ';';
        File::put($path, $content);
    }

    protected function setEnvironmentValue($key, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                "$key=" . env($key),
                "$key=$value",
                file_get_contents($path)
            ));
        }
    }

    private function validateBrandSettings(Request $request)
    {
        $request->validate([
            'companyName' => 'required|string|max:255',
          
            'email' => 'required|email|max:255',
            'phoneNumber' => 'required|string|max:20',
            'whatsapp' => 'required|string|max:20',
            'instagram' => 'required|string|max:255',
            'twitter' => 'required|string|max:255',
            'facebook' => 'required|string|max:255',
            'youtube' => 'required|string|max:255',
            'snapchat' => 'required|string|max:255',
            
        ]);
    }

    private function validateSMTPSettings(Request $request)
    {
        $request->validate([
            'host' => 'required|string',
            'port' => 'required|integer',
            'username' => 'required|string',
            'password' => 'required|string',
            'encryption' => 'required|string|in:tls,ssl,none',
        ]);
    }


        
public function events()
{
$eventFiles = File::allFiles(app_path('Events'));
$events = [];

foreach ($eventFiles as $file) {
$events[] =   pathinfo($file)['filename'];
}
return response()->json($events);

} 
}
