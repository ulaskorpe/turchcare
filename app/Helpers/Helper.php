<?php

use App\Mail\Mailer;
use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;

/**
 * Helper functions are global functions that provide convenient shortcuts for common tasks.
 * These functions are available throughout our project application, and they make it easier
 * to perform various operations without the need for more verbose code.


if (!function_exists('logging_system')) {
    function logging_system($usertype, $status, $uuid, $device_info, $user_ip, $message)
    {
        try {
            $usertype = $usertype == 'admin' ? 'admin_user' : ($usertype == 'global' ? 'global' : ($usertype == 'sms' ? 'system_sms' : 'end_user'));
            $agent = new Agent();
            $device = $agent->device();
            $browser = $agent->browser();
            $os = $agent->platform();
            $os_version = $agent->version($os);
            $browser_version = $agent->version($browser);

            $agent_info = [
                "ID" => ($uuid != null) ? $uuid : 'Visitor',
                "IP_Address" => $user_ip,
                "Device" => $device,
                "Browser" => $browser,
                "OS" => $os,
                "OS_Version" => $os_version,
                "Browser_Version" => $browser_version,
                "Device_Info" => $device_info,
                "Message" => $message,
            ];

            Log::channel($usertype)->$status(json_encode($agent_info, true));
        } catch (Exception $e) {
            Log::channel('global')->critical($message);
        }
    }
}

if (!function_exists('GUUID')) {
    function GUUID($user_guard)
    {
        switch ($user_guard) {
            case 'admin':
                $id = Admin::max('id') + 1;
                return substr(str_shuffle(md5(microtime())), -5) . $id . substr(str_shuffle(md5(microtime())), -2);
            case 'user':
                $id = User::max('id') + 1;
                return substr(str_shuffle(md5(microtime())), -5) . $id . substr(str_shuffle(md5(microtime())), -2);
            default:
                return false;
        }
    }
}
if (!function_exists('createSlug')) {
  function createSlug($string) {

    $string = strtolower($string);

    $string = preg_replace('/[^a-z0-9-]/', '-', $string);


    $string = preg_replace('/-+/', '-', $string);

    $string = trim($string, '-');

    return $string;
    }
}

/** Generate one time token for entering OTP page */
if (!function_exists('GOTT')) {
    function GOTT()
    {
        return "_" . hash('sha256', hash('sha256', Str::random(560))) . hash('sha256', date('Hs')) . date('Hs') . md5(microtime()) . hash('sha256', hash('sha256', Str::random(560))) . substr(str_shuffle(md5(microtime())), 0) . hash('sha256', hash('sha256', Str::random(560))) . date('s') . md5(hash('sha256', hash('sha256', Str::random(560)))) . substr(str_shuffle(md5(microtime())), 0) . md5(hash('sha256', hash('sha256', Str::random(560)))) . date('m') . md5(hash('sha256', hash('sha256', Str::random(560)))) . substr(str_shuffle(md5(microtime())), 0) . md5(hash('sha256', hash('sha256', Str::random(560)))) . date('s') . md5(hash('sha256', hash('sha256', Str::random(560))));
    }
}

if (!function_exists('GOTP')) {
    function GOTP()
    {

        return mt_rand(100000, 999999);
    }
}

if (!function_exists('Inputs_Options')) {
    function Inputs_Options($for_type = null)
    {
        if($for_type == 'options'){
            //only the inputs that includes options such as list, select etc..
            return ['select','checkbox','radio'];
        }

        if($for_type == 'text'){
            //only the text inputs
            return ['string'];
        }

        // All the inputs types
        return ['string','select','number','checkbox','radio'];
    }
}

if (!function_exists('Get_Json_By_Key_From_Class')) {
    function Get_Json_By_Key_From_Class($Class_name, $key, $pluck_name, $except_value = null)
    {
        if($except_value){
            return $Class_name::pluck($pluck_name)
            ->filter(fn ($item) => isset($item[$key]) && $item[$key] !== $except_value )
            ->map(fn ($item) => $item[$key])
            ->flatten()->toArray();
        }

        return $Class_name::pluck($pluck_name)
        ->filter(fn ($item) => isset($item[$key]))
        ->map(fn ($item) => $item[$key])
        ->flatten()->toArray();
    }
}

if (!function_exists('SendMail')) {
    function SendMail($email, $subject, $mailbody, $mail_content)
    {
        /** Switch cases for sending emails in different scenarios */
        try {
            Mail::send(new Mailer($email, $subject, $mailbody, $mail_content));
            return true;
        } catch (Exception $e) {
            logging_system('user', "error", "mail server", 'not_set', request()->ip(), 'Unexpected error occured while sending mail. Error: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('SendSms')) {
    function SendSms($phone, $message)
    {
        /** Direct send SMS with one time password or message with the defualt selected service */
        try{
            $service_class = '\App\Services\Sms\\'.config('services.sms.defualt').'Service';
            $sms_service = new $service_class;
            $to = $phone;
            $sms_service->sendSms($to, $message);
            logging_system('user', "info", "sms server: ".config('services.sms.defualt') , 'not_set', request()->ip(), 'Sms sent successfully to '.$phone);
            return true;
        }catch(Exception $e){
            logging_system('user', "error", "sms error using ".config('services.sms.defualt') , 'not_set', request()->ip(), 'Unexpected error occured while sending sms. Error: ' . $e->getMessage());
            logging_system('sms', "error", "sms server: ".config('services.sms.defualt') , 'not_set', request()->ip(), 'Unexpected error occured while sending sms. Error: ' . $e->getMessage());
            return false;
        }
    }
}

/** LOCAL FILE METHODS
 *
 *
 */

/** save json data in local file. return boolean */
if (!function_exists('writeJson')) {
    function writeJson($path, $filename, $key, $content)
    {
        try {
            $data = readJson($path, $filename);
            $data[$key] = $content;
            Storage::disk('public')->put($path . $filename, json_encode($data));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

/** read json data from local file. return json or null */
if (!function_exists('readJson')) {
    function readJson($path, $filename)
    {
        try {
            return Storage::disk('public')->exists($path . $filename) ? json_decode(Storage::disk('public')->get($path . $filename), true) : null;
        } catch (Exception $e) {
            return null;
        }
    }
}

/** delete data from local file. void */
if (!function_exists('deleteJson')) {
    function deleteJson($path, $filename, $key)
    {
        try {
            $data = readJson($path, $filename);
            unset($data[$key]);
            Storage::disk('public')->put($path . $filename, json_encode($data));
            return true;
        }
        //
        catch (Exception $e) {
            return false;
        }
    }
}

/** check otp of user from local file. return boolean or error message */
if (!function_exists('checkOTPJson')) {

    /*
    |--------------------------------------------------------------------------
    | Dev's Notes
    |--------------------------------------------------------------------------
    |
    | If OTP is null we look for if OTP has been already created and not expired, not to compare OTPs.
    | So this should return false to continue to process (It means OTP is not created or expired for that user)
    |
    | If OTP is given then we look for OTPs are same or not (OTP from user & OTP we store).
    | So this should return true to continue to process (It means OTP is created, not expired and the same as in the system)
    |
    */

    function checkOTPJson($path, $filename, $key, $otp = "pass", $ott = "pass")
    {
        try {
            $data = readJson($path, $filename);
            if (!$data) return ["status" => false, "message" => "Not Found", "http" => 404];
            if (!isset($data[$key])) return ["status" => false, "message" => "Not Found", "http" => 404]; // no user data
            if ($ott != "pass" & $ott != $data[$key]['OTT']) return ["status" => false, "message" => "Not Found", "http" => 404]; // ott does not match
            if (Carbon::now()->subMinutes(Config::get('common.EXTENDED_EXPIRATION_TIME')) > new Carbon($data[$key]['created_at'])) return ["status" => false, "message" => "OTP expired", "http" => 406]; // user's otp is expired
            if ($otp != "pass" && $otp != $data[$key]['OTP']) return ["status" => false, "message" => "OTP does not match", "http" => 406]; // received otp & user otp does not match

            ($otp == "pass") ?
                $return_message = ["status" => true, "message" => "OTP created already", "http" => 400] :
                $return_message = ["status" => true, "message" => "OTP matches", "http" => 200];

            return $return_message;
        }
        //
        catch (Exception $e) {
            return ["status" => false, "message" => $e->getMessage(), "http" => 400];
        }
    }
}

if (!function_exists('generatePassword')) {
    function generatePassword($min_length, $min_numbers, $min_letters, $min_capital_letters, $min_chars)
    {
        $password = '';
        $numbers = 0;
        $capitalLetters = 0;
        $letters = 0;
        $chars = 0;
        $length = 0;

        while ($length <= $min_length || $numbers <= $min_numbers || $letters <= $min_letters || $letters <= $min_capital_letters || $letters <= $min_chars) {
            $length += 1;
            switch (rand(1, 4)) {
                case 1:
                    $password .= chr(rand(48, 57)); // [0-9]
                    $numbers += 1;
                    break;
                case 2:
                    $password .= chr(rand(65, 90)); // [A-Z]
                    $capitalLetters += 1;
                    break;
                case 3:
                    $password .= chr(rand(97, 122)); // [a-z]
                    $letters += 1;
                    break;
                case 4:
                    $password .= chr(rand(33, 47)); // chars
                    $chars += 1;
                    break;
            }
        }

        return $password;
    }
}


if (!function_exists('verify_email')) {

    function verify_email($email)
    {
        try {

            // check OTP (if OTP created already)
            $check_otp = checkOTPJson('/user/otp', '/register-otps.txt', $email);
            if ($check_otp['status']) {

                logging_system('user', "error", $email, 'not_set', request()->ip(), 'Register Controller - Register -> Check OTP Json: ' . $check_otp['message']);

                return [
                    "status" => $check_otp['http'],
                    "message" => $check_otp['message'],
                    "data" => null,
                    "OTT" => null,
                    "OTP" => null
                ];
            }

            // OTP & OTT
            $otp = GOTP();
            $ott = GOTT();

            // save tokens in local file
            $data = [
                'email' => $email,
                'OTP' => $otp,
                'OTT' => $ott,
                'created_at' => Carbon::now()
            ];

            // write in local file
            $wrote = writeJson(
                '/user/otp',
                '/register-otps.txt',
                $email,
                $data
            );

            if (!$wrote) {

                logging_system('user', "critical", $email, 'not_set', request()->ip(), 'Register Controller - Register: File error');

                return [
                    "status" => 500,
                    "message" => 'Internal Server Error',
                    "data" => null,
                    "OTT" => null,
                    "OTP" => null
                ];
            }

            SendMail($email, "OTP", "mails.otpbody", ["OTP" => $otp]);

            return [
                "status" => 200,
                "message" => 'Success',
                "data" => null,
                "OTT" => $ott,
                "OTP" => $otp
            ];
        }
        //
        catch (Exception $e) {

            logging_system('user', "error", $email, 'not_set', request()->ip(), 'Verify Email: Unexpected error: ' . $e->getMessage());

            return [
                "status" => 400,
                "message" => 'Unknown Error',
                "data" => $e->getMessage(),
                "OTT" => null,
                "OTP" => null
            ];
        }
    }
}


if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return asset($path, $secure);
    }
}


if (!function_exists('uploaded_asset')) {

    function uploaded_asset($id)
    {
        try {
            // if (($asset = Upload::find($id)) != null) {
            //     return $asset->external_link == null ? my_asset($asset->file_name) : $asset->external_link;
            // }
            return static_asset('assets/img/placeholder.jpg');
        }catch(Exception $e){

        }
    }
}


if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $settings = Cache::remember('settings', 86400, function () {
            return DB::table('settings')->get();
        });

        $setting = $settings->where('name', $key)->first();

        return $setting == null ? $default : $setting->value;
    }
}

if (!function_exists('ModifyEnvFile')) {
    /**
     * Modify the Env File values.
     * @param  String type
     * @param  String value
     * @return bool
     */
    function ModifyEnvFile($type, $val)
    {
        try{
            // Getting environment file
            $envFilePath = base_path('.env');

            // Check if the .env file exists
            if (File::exists($envFilePath)) {
                // Read the current content of the .env file
                $currentEnvValues = File::get($envFilePath);

                // Check if the key exists
                if (preg_match("/\b{$type}=.*/", $currentEnvValues)) {
                    // Update the existing key
                    $newEnvValues = preg_replace(
                        "/\b{$type}=.*/",
                        "{$type}={$val}",
                        $currentEnvValues
                    );
                } else {
                    // Add a new key-value pair
                    $newEnvValues = $currentEnvValues . "\r\n{$type}={$val}";
                }
            } else {
                // .env file doesn't exist, create it with the new key-value pair
                $newEnvValues = "{$type}={$val}\n";
            }

            // Write the updated content to the .env file
            File::put($envFilePath, $newEnvValues);


            return true;
        }catch(Exception $e){
            return false;
        }
    }
}

if (!function_exists('isUser')) {

    function isUser(){
        $user = Auth::guard('user-api')->user();
        if($user){
            return $user;
        }
        return false;
    }
}
