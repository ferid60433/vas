<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create([
            'letter' => 'S',
            'code' => 'Stop',
            'confirmation_message' => "You have successfully unsubscribed from our service. You will no longer receive any messages from us. Thanks for using our service.\nGood bye",
            'mandatory' => true,
        ]);

        Service::create([
            'letter' => 'H',
            'code' => 'Help',
            'confirmation_message' => "Andegna Value Added Service\n\nThanks for getting interested in our service.\nSend:\n - H for Help\n - S for Unsubscribe",
            'mandatory' => true,
        ]);
    }
}
