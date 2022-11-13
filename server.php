<?php
session_start();

$username = "";
$email    = "";
$errors = array();

$db = mysqli_connect('localhost', 'root', '', 'registration');
if (!$db) die("Błąd połączenia z bazą danych");
$isLogged = false;

function register($db, $errors) {
    if (!isset($_REQUEST['reg_user'])) return;
    $username = @mysqli_real_escape_string($db, $_REQUEST['username']);
    $email = @mysqli_real_escape_string($db, $_REQUEST['email']);
    $password_1 = @mysqli_real_escape_string($db, $_REQUEST['password_1']);
    $password_2 = @mysqli_real_escape_string($db, $_REQUEST['password_2']);

    if (empty($username)) { array_push($errors, "Nazwa uzytkownika jest wymagana"); }
    if (empty($email)) { array_push($errors, "Email jest wymagany"); }
    if (empty($password_1)) { array_push($errors, "Haslo jest wymagane"); }
    if ($password_1 != $password_2) {
        array_push($errors, "Hasla nie sa takie same");
    }

    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) {
            array_push($errors, "Konto o takiej nazwie uzytkownika juz istnieje");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Konto o takim adresie email juz istnieje");
        }
    }

    if (count($errors) == 0) {
        $password = md5($password_1);

        $query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "Zalogowales sie";
        // header('location: Dom.html');

        return json_encode(
            ['status'=>true, 'data'=>[ 'username'=>$username], 'message'=>'Udalo sie zarejestrowac uzytkownika', 'errors'=>$errors]
        );
    }

    return json_encode(
        ['status'=>false, 'data'=>[], 'message'=>'Nie udalo sie zarejestrowac uzytkownika', 'errors'=>$errors]
    );

}

//logowanie

function login($db, $errors)
{

    if (isset($_REQUEST['login_user'])) {
        $username = mysqli_real_escape_string($db, $_REQUEST['username']);
        $password = mysqli_real_escape_string($db, $_REQUEST['password']);

        if (empty($username)) {
            array_push($errors, "Nazwa uzytkownika jest wymagana");
        }
        if (empty($password)) {
            array_push($errors, "Haslo jest wymagane");
        }

        if (count($errors) == 0) {
            $password = md5($password);
            $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $results = mysqli_query($db, $query);


            if (mysqli_num_rows($results) == 1) {
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "Zalogowales sie";
                //header('location: Dom.html');

                return json_encode(
                    ['status' => true, 'data' => ['username' => $username], 'message' => 'Udalo sie zalogowac', 'errors' => $errors]
                );
            }


        }
    }
    array_push($errors, "Wpisz poprawne dane");
    return json_encode(
        ['status'=>false, 'data'=>[], 'message'=>'Nie udalo sie zalogowac', 'errors'=>$errors]
    );

}
