<?php


namespace SmartContact\UiMaker\modules;

use Illuminate\Support\Facades\Http;

class ToMicroservice implements UIBaseContract
{
    private $url;

    public function __construct($url)
    {
        $this->url = "$url?is_final_microservice=true";
    }

    public function retrieveUi(): array
    {
        $response = Http::get($this->url);

        return $response->json();
    }
}