<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 18.03.2020
 * Time: 17:20
 */

$name = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try{
        $user = new \app\entity\User($env);
        // Validation
        if( $user->check_email_already_exists($_POST['email'])){
                echo json_encode(['error'=>'Такая электронная почта уже существует']);
                return true;
        }
        // if validation is ok then we create new user
        if(isset($_POST['email']) and $_POST['password'] and $_POST['login']){
            echo $user->create();
        }
    }catch (Exception $exception){
        echo json_encode($exception->getMessage());
    }
    return true;
}

?>
<div class="alert alert-success text-center">Регистрация</div>
<div class="alert alert-danger" id="register_error" style="display: none">Ошибки:</div>
<form class="text-center"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="frmLogin">
        <div><label for="login">Имя</label></div>
        <div><input name="login" type="text" value="" class="input-field" required  minlength="3"></div>

        <div><label for="email">Почта</label></div>
        <div><input name="email" type="email" value="" class="input-field" required></div>

        <div><label for="password">Пароль</label></div>
        <div><input name="password" type="password" value="" class="input-field" required minlength="8"></div>

        <div><input type="submit" name="submit" value="Регистрация" class="form-submit-button"></span></div>
    <div><a class="btn btn-primary mt-3" href="<?php echo strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://'.$_SERVER['SERVER_NAME'].'/login'?>">Логин</a></div>

</form>
