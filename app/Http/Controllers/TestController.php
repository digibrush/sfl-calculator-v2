<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Spatie\SlackAlerts\Facades\SlackAlert;

class TestController extends Controller
{
    public function test()
    {
        SlackAlert::blocks([
            [
                "type" => "header",
                "text" => [
                    "type" => "plain_text",
                    "text" => "Budget Performance"
                ]
            ],
            [
                "type" => "section",
                "text" => [
                    "type" => "mrkdwn",
                    "text" => "You have a new subscriber to the test newsletter!"
                ]
            ],
            [
                "type" => "divider",
            ]
        ]);
    }
}
