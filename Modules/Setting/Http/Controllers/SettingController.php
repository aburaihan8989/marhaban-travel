<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Http\Requests\StoreSettingsRequest;
use Modules\Setting\Http\Requests\StoreSmtpSettingsRequest;

class SettingController extends Controller
{

    public function index() {
        abort_if(Gate::denies('access_settings'), 403);

        $settings = Setting::firstOrFail();

        return view('setting::index', compact('settings'));
    }


    public function reward() {
        abort_if(Gate::denies('access_settings'), 403);

        $settings = Setting::firstOrFail();

        return view('setting::reward', compact('settings'));
    }


    public function reward_update(Request $request) {
        Setting::firstOrFail()->update([
            'level1_rewards' => $request->level1_rewards,
            'level2_rewards' => $request->level2_rewards,
            'level3_rewards' => $request->level3_rewards,
            'level4_rewards' => $request->level4_rewards,

            'referal1_rewards' => $request->referal1_rewards,
            'referal2_rewards' => $request->referal2_rewards,
            'referal3_rewards' => $request->referal3_rewards,
            'referal4_rewards' => $request->referal4_rewards,

            'promo_umroh' => $request->promo_umroh,

        ]);

        cache()->forget('settings');

        toast('Rewards Settings Updated!', 'info');

        return redirect()->route('settings-rewards.index');
    }


    public function reward_hajj_update(Request $request) {
        Setting::firstOrFail()->update([
            'level11_rewards' => $request->level11_rewards,
            'level22_rewards' => $request->level22_rewards,
            'level33_rewards' => $request->level33_rewards,
            'level44_rewards' => $request->level44_rewards,

            'referal11_rewards' => $request->referal11_rewards,

            'promo_haji' => $request->promo_haji,

        ]);

        cache()->forget('settings');

        toast('Rewards Settings Updated!', 'info');

        return redirect()->route('settings-rewards.index');
    }


    public function update(StoreSettingsRequest $request) {
        Setting::firstOrFail()->update([
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_phone' => $request->company_phone,
            'notification_email' => $request->notification_email,
            'company_address' => $request->company_address,
            'default_currency_id' => $request->default_currency_id,
            'default_currency_position' => $request->default_currency_position,
        ]);

        cache()->forget('settings');

        toast('Settings Updated!', 'info');

        return redirect()->route('settings.index');
    }


    public function updateSmtp(StoreSmtpSettingsRequest $request) {
        $toReplace = array(
            'MAIL_MAILER='.env('MAIL_HOST'),
            'MAIL_HOST="'.env('MAIL_HOST').'"',
            'MAIL_PORT='.env('MAIL_PORT'),
            'MAIL_FROM_ADDRESS="'.env('MAIL_FROM_ADDRESS').'"',
            'MAIL_FROM_NAME="'.env('MAIL_FROM_NAME').'"',
            'MAIL_USERNAME="'.env('MAIL_USERNAME').'"',
            'MAIL_PASSWORD="'.env('MAIL_PASSWORD').'"',
            'MAIL_ENCRYPTION="'.env('MAIL_ENCRYPTION').'"'
        );

        $replaceWith = array(
            'MAIL_MAILER='.$request->mail_mailer,
            'MAIL_HOST="'.$request->mail_host.'"',
            'MAIL_PORT='.$request->mail_port,
            'MAIL_FROM_ADDRESS="'.$request->mail_from_address.'"',
            'MAIL_FROM_NAME="'.$request->mail_from_name.'"',
            'MAIL_USERNAME="'.$request->mail_username.'"',
            'MAIL_PASSWORD="'.$request->mail_password.'"',
            'MAIL_ENCRYPTION="'.$request->mail_encryption.'"');

        try {
            file_put_contents(base_path('.env'), str_replace($toReplace, $replaceWith, file_get_contents(base_path('.env'))));
            Artisan::call('cache:clear');

            toast('Mail Settings Updated!', 'info');
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('settings_smtp_message', 'Something Went Wrong!');
        }

        return redirect()->route('settings.index');
    }
}
