<?php

use Illuminate\Database\Seeder;
use Vas\Lookup;

class LookupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pairs = $this->defaultValue();

        foreach ($pairs as $key => $value) {
            Lookup::updateOrCreate(
                ['key' => $key],
                ['value' => $value]);
        }
    }

    protected function defaultValue()
    {
        return [
            'OWNER_ADDRESS' => '21631393',

            'MESSAGE_STOP' => "You have successfully unsubscribed from our service. You will no longer receive any messages from us. Thanks for using our service.\nGood bye",
            'MESSAGE_HELP' => "Andegna Value Added Service\n\nThanks for getting interested in our service.\nSend:\n - H for Help\n - S for Unsubscribe",
            'MESSAGE_EMPTY' => "You have sent an empty message. Please send 'help' for more detail.",
            'MESSAGE_DEFAULT' => "Sorry but we couldn't understand your message. Please send 'help' for more detail.",
            'MESSAGE_OWNER_COMMAND' => 'Command successful. Message will be broadcasted to the subscribers.',
            'MESSAGE_NOT_SUBSCRIBED_YET' => "You are not subscribed to our service. Please send 'help' for more detail.",
            'MESSAGE_MO' => "Please don't send commands to MO, send to MT fro free",
        ];
    }
}
