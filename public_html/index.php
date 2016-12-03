<?php

require_once '../vendor/autoload.php';

$app = new \Silex\Application();
// @todo figure how to install silex PHPStorm support
//$app->register(new Sorien\Provider\PimpleDumpProvider());
$app['debug'] = true;


// LESSON 1
$app->get('/', function() {
    return new Symfony\Component\HttpFoundation\Response('Hello!');
});
//
// LESSON 2
$app->get("/users/{id}", function($id) {
    return "User - {$id}";
})
    ->value('id', 0) // default
    ->assert('id', "\d+"); //
;


// LESSON 3 Routing & Dynamic ROuting
$messages = [
    1 => [
        'date' => '2016-11-17',
        'name' => 'Lily',
        'title' => 'I like pie',
        'body' => "It's so good!"
    ],
    2 => [
        'date' => '2016-11-18',
        'name' => 'Gog',
        'title' => 'I like ham',
        'body' => "It's so smoked!"
    ],
];

$app->get('/thread', function() use ($messages) {
    $output = '';
    foreach ($messages as $m) {
        $output .= $m['title'];
        $output .= "<br/ >";
    }
    return $output;
});

$app->get('/thread/{id}', function (Silex\Application $app, $id) use ($messages) {
    if (!isset($messages[$id])) {
        $app->abort(404, "Post $id does not exist");
    }

    $post = $messages[$id];

    return "<h1>{$post['title']}</h1>" .
            "<p>{$post['body']}</p>";
});
//

// Lesson 4
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->post("/feedback", function (Request $request) {

    $message = 'lala'; //$request->get('message');

    mail('martin.suas@gmail.com', '[YourSite] Feedback', $message);

    return new Response('Thank you for your feedback!', 201);
});

//


$app->get("/feedback2", function (Silex\Application $app, $id)  {
    /**
    $mail = new PHPMailer();
    $mail->Host ='smtp.gmail.com';
    $mail->SMTPAuth = true; // Allow SMTP authentication
    $mail->Username = 'martin.suas.dev@gmail.com';
    $mail->Password = 'celular1';
    $mail->SMTPSecure = 'tls'; // Chose encryption, could also be ssl
    $mail->Port = 587;

    $mail->setFrom('martin.suas.dev@gmail.com', 'Weekly Reporter');
    $mail->addAddress('martin.suas.qa@gmail.com','Sanjay Hoerer');
    $mail->addReplyTo('martin.suas@gmail.com', 'Information');
    $mail->addBCC('martin.suas.dev@gmail.com', 'Martin Suarez');

    $mail->addAttachment(__DIR__ . '/../resources/download/silly_text.txt', 'actually_this.txt');
    $mail->isHTML(true);

    $mail->Subject ="Your August Weekly Report";
    $mail->Body = "<h1>Your August Weekly Report is here!</h1>
<p>Please, tell us how we did after you see this wonderful report down here.</p>";
    $mail->AltBody = $mail->Body;

    // UGLY! ignore
    //mail('martin.suas@gmail.com', '[YourSite] Feedback', 'lala');

    if ($mail->send()) {
        $message = 'Message sent successful! Arigato!';
    } else {
        $message = 'Mailer Error: ' . $mail->ErrorInfo;
    }
    return $message;
     * *//
});


$app->run();