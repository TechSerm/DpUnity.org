<?php

namespace App\Console\Commands;

use App\Enums\SettingEnum;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class MigrateSettingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:setting_options';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $keys = SettingEnum::getKeys();

        $settingOptions = Setting::all();

        foreach ($settingOptions as $settingOption) {
            if(!in_array($settingOption->key, $keys)){
                $settingOption->delete();
                echo "Successfully deleted ".$settingOption->key. " options\n";
            }
        }

        foreach ($keys as $key) {
            $setting = Setting::where(['key' => $key])->first();
            if(empty($setting)) {
                Setting::create([
                    'uuid' => Str::uuid(),
                    'key' => $key
                ]);
                echo "Successfully created ".$key. " options\n";
            }
        }



        return Command::SUCCESS;
    }
}
