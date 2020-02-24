<?php

require __DIR__ . '/vendor/autoload.php';


use \LINE\LINEBot\SignatureValidator as SignatureValidator;

// load config
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// initiate app
$configs =  [
	'settings' => ['displayErrorDetails' => true],
];
$app = new Slim\App($configs);

/* ROUTES */
$app->get('/', function ($request, $response) {
	return "Line Bot Success";
});

$app->post('/', function ($request, $response)
{
	// get request body and line signature header
	$body 	   = file_get_contents('php://input');
	$signature = $_SERVER['HTTP_X_LINE_SIGNATURE'];

	// log body and signature
	file_put_contents('php://stderr', 'Body: '.$body);

	// is LINE_SIGNATURE exists in request header?
	if (empty($signature)){
		return $response->withStatus(400, 'Signature not set');
	}

	// is this request comes from LINE?
	if($_ENV['PASS_SIGNATURE'] == false && ! SignatureValidator::validateSignature($body, $_ENV['CHANNEL_SECRET'], $signature)){
		return $response->withStatus(400, 'Invalid signature');
	}

	// init bot
	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['CHANNEL_ACCESS_TOKEN']);
	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['CHANNEL_SECRET']]);
	$data = json_decode($body, true);
	foreach ($data['events'] as $event)
	{
		$userMessage = $event['message']['text'];
		if(strtolower($userMessage) == 'hai')
		{
			$message = "Halo Halo Hai";
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
			$result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		
		}
		
		
		$userMessage = $event['message']['text'];
		if(strtolower($userMessage) == "ceo"){
			$ImageCarouselTemplateBuilder = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder([
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder("https://d2zvxgfo5lha7k.cloudfront.net/original/commons/letter_from_the_ceo.jpg",
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('CEO Dicoding',"https://www.dicoding.com/about")),
			  ]);
			$templateMessage = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('ceo dicoding',$ImageCarouselTemplateBuilder);
			$result = $bot->replyMessage($event['replyToken'], $templateMessage);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		}
			
			
		
		$userMessage = $event['message']['text'];
		if(strtolower($userMessage) == "learning path"){
			$ImageCarouselTemplateBuilder = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder([
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder("https://d2zvxgfo5lha7k.cloudfront.net/original/academy/android_developer_logo_201219145044.png",
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('Android Dev',"https://www.dicoding.com/learningpaths/7")),
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder("https://d2zvxgfo5lha7k.cloudfront.net/original/academy/cloud_developer_logo_201219145056.png",
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('Cloud Dev',"https://www.dicoding.com/learningpaths/2")),
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder("https://d2zvxgfo5lha7k.cloudfront.net/original/academy/web_developer_logo_201219135331.png",
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('FE Web Dev',"https://www.dicoding.com/learningpaths/22")),
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder("https://d2zvxgfo5lha7k.cloudfront.net/original/academy/ar_vr_developer_logo_301219145216.png",
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('AR/VR Dev',"https://www.dicoding.com/learningpaths/23")),
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder("https://d2zvxgfo5lha7k.cloudfront.net/original/academy/unity_game_developer_logo_201219135320.png",
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('Unity G.Dev',"https://www.dicoding.com/learningpaths/13")),
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder("https://d2zvxgfo5lha7k.cloudfront.net/original/academy/construct_game_developer_logo_201219135236.png",
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('Const G.Dev',"https://www.dicoding.com/learningpaths/17")),
			  ]);
			$templateMessage = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('learning path',$ImageCarouselTemplateBuilder);
			$result = $bot->replyMessage($event['replyToken'], $templateMessage);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
			}
					
		$userMessage = $event['message']['text'];
		if(strtolower($userMessage) == "lp android"){
			$carouselTemplateBuilder = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder([
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Memulai Pemrograman Dengan Kotlin", "Disusun oleh: Dicoding Indonesia","https://d2zvxgfo5lha7k.cloudfront.net/original/academy/memulai_pemrograman_dengan_kotlin_logo_071119141033.png",[
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('buka',"https://www.dicoding.com/academies/80"),
			  ]),
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Belajar Aplikasi Android untuk Pemula", "Disusun oleh: Google ATP","https://d2zvxgfo5lha7k.cloudfront.net/original/academy/belajar_membuat_aplikasi_android_untuk_pemula_logo_071119140631.png",[
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('Buka',"https://www.dicoding.com/academies/51"),
			  ]),
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Belajar Fundamental Aplikasi Android", "Disusun oleh: Google ATP","https://d2zvxgfo5lha7k.cloudfront.net/original/academy/menjadi_android_developer_expert_logo_071119140536.png",[
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('buka',"https://www.dicoding.com/academies/14"),
			  ]),
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Belajar Android Jetpack Pro", "Disusun oleh: Google ATP","https://d2zvxgfo5lha7k.cloudfront.net/original/academy/menjadi_android_developer_expert_logo_071119140536.png",[
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('buka',"https://www.dicoding.com/academies/129"),
			  ]),
			  ]);
			$templateMessage = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('learning path android',$carouselTemplateBuilder);
			$result = $bot->replyMessage($event['replyToken'], $templateMessage);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
			}
			
		$userMessage = $event['message']['text'];
		if(strtolower($userMessage) == "learning cloud"){
			$carouselTemplateBuilder = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder([
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Belajar Dasar-Dasar Azure Cloud", "Disusun oleh: Microsoft","https://d2zvxgfo5lha7k.cloudfront.net/original/academy/belajar_dasar_dasar_azure_cloud_logo_071119141523.png",[
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('buka',"https://www.dicoding.com/academies/144"),
			  ]),
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Azure Cloud Developer", "Disusun oleh: Dicoding Indonesia","https://d2zvxgfo5lha7k.cloudfront.net/original/academy/menjadi_azure_cloud_developer_logo_231219145948.png",[
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('buka',"https://www.dicoding.com/academies/83"),
			  ]),
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("AWS Solutions Architect Associate", "Disusun oleh: Dicoding Indonesia","https://d2zvxgfo5lha7k.cloudfront.net/original/academy/belajar_menjadi_aws_solutions_architect_associate_logo_071119141240.png",[
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('buka',"https://www.dicoding.com/academies/104"),
			  ]),
			  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Google Cloud Engineer", "Disusun oleh: Google ATP","https://d2zvxgfo5lha7k.cloudfront.net/original/academy/menjadi_google_cloud_engineer_logo_071119141421.png",[
			  new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('buka',"https://www.dicoding.com/academies/133"),
			  ]),
			  ]);
			$templateMessage = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('learning path cloud',$carouselTemplateBuilder);
			$result = $bot->replyMessage($event['replyToken'], $templateMessage);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
			}
		
	}
	

});

// $app->get('/push/{to}/{message}', function ($request, $response, $args)
// {
// 	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['CHANNEL_ACCESS_TOKEN']);
// 	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['CHANNEL_SECRET']]);

// 	$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($args['message']);
// 	$result = $bot->pushMessage($args['to'], $textMessageBuilder);

// 	return $result->getHTTPStatus() . ' ' . $result->getRawBody();
// });

/* JUST RUN IT */
$app->run();