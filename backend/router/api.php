<?php

namespace Router;

use Klein\Klein;
use App\Users;

$klein = new Klein();
$users = new Users();

$headersPost = [
  "Access-Control-Allow-Origin" => "*",
  "Access-Control-Allow-Methods" => "POST",
  "Access-Control-Max-Age" => "3600",
  "Access-Control-Allow-Headers" => "Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With",
  "Content-Type" => "application/json; charset=UTF-8"
];

$headersGet = [
  "Access-Control-Allow-Origin" => "*",
  "Access-Control-Allow-Methods" => "GET",
  "Access-Control-Allow-Headers" => "access",
  "Access-Control-Allow-Credentials" => "true",
  "Content-Type" => "application/json; charset=UTF-8"
];

$klein->respond('OPTIONS', null, function ($request, $response) use ($users, $headersPost){
  foreach ($headersPost as $key => $value)
  $response->header($key, $value);
});

$klein->respond('GET', '/read', function ($request, $response) use ($users, $headersGet) {

  foreach ($headersGet as $key => $value)
    $response->header($key, $value);

  return json_encode($users->read()->fetchAll(\PDO::FETCH_ASSOC));
});

$klein->respond('POST', '/create', function ($request, $response, $service, $app) use ($users, $headersPost) {

  foreach ($headersPost as $key => $value)
    $response->header($key, $value);

  $data = json_decode($request->body());
  if (
    !empty($data->firstName) &&
    !empty($data->lastName) &&
    !empty($data->email)
  ) {

    $users->firstname = $data->firstName;
    $users->lastname = $data->lastName;
    $users->email = $data->email;

    if ($users->create()) {
      $response->code(201);
      echo json_encode(array(array("message" => "Пользователь зарегистрирован.")));
    } else {
      $response->code(503);
      echo json_encode(array(array("message" => "Невозможно зарегистрировать пользователя.")));
    }
  } else {
    $response->code(400);
    echo json_encode(array(array("message" => "Невозможно зарегистрировать пользователя. Данные неполные.")));
  }
});

$klein->respond('POST', '/delete', function ($request, $response, $service, $app) use ($users, $headersPost) {

  foreach ($headersPost as $key => $value)
    $response->header($key, $value);

  $data = json_decode($request->body());
  // var_dump($data);
  if (!empty($data->id)) {

    $users->id = $data->id;

    if ($users->delete()) {
      $response->code(201);
      echo json_encode(array(array("message" => "Пользователь удален.")));
    } else {
      $response->code(503);
      echo json_encode(array(array("message" => "Невозможно удалить пользователя.")));
    }
  } else {
    $response->code(400);
    echo json_encode(array(array("message" => "Невозможно удалить пользователя. Данные неполные.")));
  }
});

$klein->dispatch();
