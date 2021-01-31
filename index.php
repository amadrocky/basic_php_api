<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require 'vendor/autoload.php';

$router = new AltoRouter();

$router->map('GET', '/cities', function() {
    include('template.php');

    $request = $pdo->prepare("SELECT * FROM `city`");

    if($request->execute()){
        $results = $request->fetchAll();
        
        $success = true;
        $data['total'] = count($results);
        $data['cities'] = $results;
    } else {
        $msg = "Une erreur s'est produite";
    }

    reponse_json($success, $data);
});

$router->map('GET', '/cities/[i:id]', function($id) {
    include('template.php');

    $request = $pdo->prepare("SELECT * FROM `city` WHERE `city_id` = $id");

    if($request->execute()){
        $results = $request->fetchAll();
        
        $success = true;
        $data['city'] = $results;
    } else {
        $msg = "Une erreur s'est produite";
    }

    reponse_json($success, $data);
});

$router->map('POST', '/cities', function() {
    include('template.php');

    if(isset($_POST['country']) && isset($_POST['cityLabel'])) {
        $requete = $pdo->prepare("INSERT INTO `city` (`city_id`, `country`, `city_label`, `CREATION_DATE`) VALUES (NULL, 'country', 'cityLabel', CURRENT_TIMESTAMP");
        $requete->bindParam(':country', $_POST['country']);
        $requete->bindParam(':cityLabel', $_POST['cityLabel']);

        $requete->execute();
    } else {
        $msg = "Une erreur s'est produite";
    }

    reponse_json($success, $data);
});

$router->map('PUT', '/cities/[i:id]', function($id) {
    include('template.php');

    $request = $pdo->prepare("UPDATE `city` SET `country` = 'country', `city_label` = 'cityLabel', `CREATION_DATE` = CURRENT_TIMESTAMP WHERE `city`.`city_id` = $id");
    $request->bindParam(':country', $_POST['country']);
    $request->bindParam(':cityLabel', $_POST['cityLabel']);

    if($request->execute()){
        $results = $request->fetchAll();
        
        $success = true;
        $data['city'] = $results;
    } else {
        $msg = "Une erreur s'est produite";
    }

    reponse_json($success, $data);
});

$router->map('DELETE', '/cities/[i:id]', function($id) {
    include('template.php');

    $request = $pdo->prepare("DELETE FROM `city` WHERE `city`.`city_id` = $id");

    if($request->execute()){
        $results = $request->fetchAll();
        
        $success = true;
        $data['city'] = $results;
    } else {
        $msg = "Une erreur s'est produite";
    }

    reponse_json($success, $data);
});

$match = $router->match();

if ($match !== null) {
    call_user_func_array($match['target'], $match['params']);
}