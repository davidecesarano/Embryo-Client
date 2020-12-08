<?php 

    require __DIR__.'/../vendor/autoload.php';

    use Embryo\Http\Client\ClientFactory;
    use Embryo\Http\Emitter\Emitter;
    use Embryo\Http\Factory\{RequestFactory, ServerRequestFactory};
    
    $emitter = new Emitter;
    
    //$request = (new RequestFactory)->createRequest('GET', 'https://server.rest-sites.multiversity.click/pegaso/ecp');
    //$request = $request->withHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImE3YTNjN2JhODdkNGYzMDZlNjkwZGNmZmJhYzM3NTE1N2I1YmFlNmVhMzlmMmFjMjE5ZmQ3N2RkZmJmMjA4MjQwZjA0MTVmM2YwZTMzMGQ3In0.eyJhdWQiOiI1IiwianRpIjoiYTdhM2M3YmE4N2Q0ZjMwNmU2OTBkY2ZmYmFjMzc1MTU3YjViYWU2ZWEzOWYyYWMyMTlmZDc3ZGRmYmYyMDgyNDBmMDQxNWYzZjBlMzMwZDciLCJpYXQiOjE2MDE0NzQ3NjcsIm5iZiI6MTYwMTQ3NDc2NywiZXhwIjoyMjMyNjI2NzY3LCJzdWIiOiIyIiwic2NvcGVzIjpbIioiXX0.l89Fxvc0YAphKCAhnzO76PWpbMIuzAQPCEthXkQ61Y0fvdt5HjzhH0JpanuD2SxzAXTDgcwAT9y0Mdmff_slkckMPf5svWBMbkEQOetHMSOwZP5E-9kCyXboBrvza8vPSb0dvGQnv5O-bJMtuzG0WMHTtNS0Ye93MQB1D1YGfYzlOPtH4-xDwpumkb3jmuQuXTVXJlw7T0Jr75-8ZkJd1QV3MxrmrM0UkT9CAZKOOcUyeB53Y54tk9FtbtoHLBMXs7Pcf-bU6CV6cWeNpiDSq5bI-_EyhkoFonvanj9Bsy3rwyqS0GEiPAIWiMpGm0lHFLoe1SYoOOrbQ6gu1VozLJcy6QaAdGzTEDLoWzklkWWVWfi3fVwvkGh8YA-v1af5MajAYJsWB0VBDgkoYHc_0WPYUBvpKINYnhsTA3GwChQOO6grW6gevSgcqX79qxudbj2uYyBUqcdeG4NmikpZcbu0hKCzn5rmKMsFeFSugjns5Zx0fnoBOwAhRsvnbuFb0i3raXiaHKdHq3e0vZ8r-IIbMwDwOaTGRQp_Kz_bjW0u9swSw7I6ih0YDxbljk-0PN5gnPCahbtvvGuKwaTDlgkndS9ayokrT2mCg2rsbnW7VB467Kswbog7bzogegXMOYJdAHBYfVcjmqpCXebMRblpTFEiWpwXAdB7Z1eZdIE');
    //$client = new Client;
    //
    //$response = $client->sendRequest($request);
    //$emitter->emit($response);

    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImE3YTNjN2JhODdkNGYzMDZlNjkwZGNmZmJhYzM3NTE1N2I1YmFlNmVhMzlmMmFjMjE5ZmQ3N2RkZmJmMjA4MjQwZjA0MTVmM2YwZTMzMGQ3In0.eyJhdWQiOiI1IiwianRpIjoiYTdhM2M3YmE4N2Q0ZjMwNmU2OTBkY2ZmYmFjMzc1MTU3YjViYWU2ZWEzOWYyYWMyMTlmZDc3ZGRmYmYyMDgyNDBmMDQxNWYzZjBlMzMwZDciLCJpYXQiOjE2MDE0NzQ3NjcsIm5iZiI6MTYwMTQ3NDc2NywiZXhwIjoyMjMyNjI2NzY3LCJzdWIiOiIyIiwic2NvcGVzIjpbIioiXX0.l89Fxvc0YAphKCAhnzO76PWpbMIuzAQPCEthXkQ61Y0fvdt5HjzhH0JpanuD2SxzAXTDgcwAT9y0Mdmff_slkckMPf5svWBMbkEQOetHMSOwZP5E-9kCyXboBrvza8vPSb0dvGQnv5O-bJMtuzG0WMHTtNS0Ye93MQB1D1YGfYzlOPtH4-xDwpumkb3jmuQuXTVXJlw7T0Jr75-8ZkJd1QV3MxrmrM0UkT9CAZKOOcUyeB53Y54tk9FtbtoHLBMXs7Pcf-bU6CV6cWeNpiDSq5bI-_EyhkoFonvanj9Bsy3rwyqS0GEiPAIWiMpGm0lHFLoe1SYoOOrbQ6gu1VozLJcy6QaAdGzTEDLoWzklkWWVWfi3fVwvkGh8YA-v1af5MajAYJsWB0VBDgkoYHc_0WPYUBvpKINYnhsTA3GwChQOO6grW6gevSgcqX79qxudbj2uYyBUqcdeG4NmikpZcbu0hKCzn5rmKMsFeFSugjns5Zx0fnoBOwAhRsvnbuFb0i3raXiaHKdHq3e0vZ8r-IIbMwDwOaTGRQp_Kz_bjW0u9swSw7I6ih0YDxbljk-0PN5gnPCahbtvvGuKwaTDlgkndS9ayokrT2mCg2rsbnW7VB467Kswbog7bzogegXMOYJdAHBYfVcjmqpCXebMRblpTFEiWpwXAdB7Z1eZdIE';
    $http = new ClientFactory;
    /*$response = $http->withToken($token)->get('https://server.rest-sites.multiversity.click/pegaso/ecp', [
        'ciao' => 'as',
        'asd' => 'asdd'
    ]);*/

    $response = (new ClientFactory)->withHeaders([
        'Content-Type' => 'application/json'
    ])->post('https://jsonplaceholder.typicode.com/posts', [
        'userId' => 15465446,
        'title' => 'Ciocas',
        'body' => 'asdsad'
    ]);
    $emitter->emit($response);
