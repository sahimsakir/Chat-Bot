<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use Illuminate\Http\Request;

class BotController extends Controller
{
    //
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}',function($botman,$message){
            $attachment = new Image('https://botman.io/img/logo.png');
            $message = OutgoingMessage::create("write 'hi' for testing...")
                ->withAttachment($attachment);

                // $message = Question::create("write 'hi' for testing...")
                // ->fallback('did not get it')
                // ->callbackId('ask_reason')
                // ->addButtons([
                //     Button::create('Service')->value('service'),
                //     Button::create('Resource')->value('resource'),
                // ]);

            if ($message == 'hi' || $message == 'Hi' || $message == 'HI') {
                $this->askName($botman);
            }else{
                $botman->reply($message);
            }

        });

        $botman->listen();
    }

    public function askName($botman)
    {
        $botman->ask("Hello! What is Your Name?",function(Answer $answer){
            $name = $answer->getText();

            $this->say('Nice to meet you '.$name);
        });
    }
}
