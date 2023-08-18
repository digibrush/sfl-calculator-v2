<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Http\Request;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Messages\Incoming\Answer;
class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $config = [];
        $botman = BotManFactory::create($config, new LaravelCache());
        $botman->hears('{message}', function($botman, $message) {
            if ($message == 'hi') {
                $botman->typesAndWaits(2);
                $this->askAction($botman);
            }else{
                $botman->reply("write 'hi' to start the conversation...");
            }

        });

        $botman->listen();
    }

    /**
     * Place your BotMan logic here.
     */
    public function askAction($botman)
    {
        $question = Question::create('What do want to do?')
            ->fallback('Unable to comply with the request')
            ->callbackId('aaction')
            ->addButtons([
                Button::create('View All Products')->value('view_products'),
                Button::create('Create A New Product')->value('create_product'),
                Button::create('Create/Edit Quotes')->value('quotes'),
            ]);

        $botman->typesAndWaits(2);
        $botman->ask($question, function(Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue();
                if ($selectedValue == "view_products") {
                    $this->say('Click <a href="/admin/products" target="_blank">here</a> to navigate to the products section');
                }
                if ($selectedValue == "create_product") {
                    $this->say('Click <a href="/admin/products/create" target="_blank">here</a> to navigate to create a product');
                }
            }
        });
    }
}
