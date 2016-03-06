<?php
require 'vendor/autoload.php';

$config  = Symfony\Component\Yaml\Yaml::parse(file_get_contents('config.yml'));
$crawler = new Fuz\LeBonCoin\Crawler();

foreach ($config['urls'] as $title => $url) {
    $ads = $crawler->getAds($url, 100);

    $new = [];
    foreach ($ads as $ad) {
        if (!is_file($test = __DIR__.'/cache/'.sha1(serialize($ad)).'.srz')) {
            touch($test);
            $new[] = $ad;
        }
    }

    if ($new) {
        $twig = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__.'/twig'));
        $body = $twig->render('main.html.twig', ['ads' => $new]);

        $transport = Swift_SmtpTransport::newInstance($config['mail']['smtp'], $config['mail']['port'])
           ->setUsername($config['mail']['user'])
           ->setPassword($config['mail']['pass'])
        ;

        $message = Swift_Message::newInstance()
           ->setSubject('LeBonCoin: '.count($new).' new ads for '.$title)
           ->setFrom([$config['mail']['from_mail'] => $config['mail']['from_name']])
           ->setTo([$config['mail']['to_mail'] => $config['mail']['to_name']])
           ->setBody($body, 'text/html')
        ;

        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }
}
