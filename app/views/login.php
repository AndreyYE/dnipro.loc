<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try{
        $user = new \app\entity\User($env);
        if( !$user->login()){
            echo json_encode(['error'=>'Вы неверно указали почту или пароль']);
            return true;
        }else{
            echo json_encode(['success'=>'Ура вы пошли на сайт']);
            return true;
        }
    }
    catch (Exception $exception){
        echo json_encode([$exception->getMessage()]);
    }
    return true;
}
?>
<div class="alert alert-success text-center">Логин</div>
<div class="alert alert-danger" id="register_error" style="display: none">Ошибки:</div>
<form class="text-center"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="frmLogin1">
    <div><label for="email">Почта</label></div>
    <div><input name="email" type="email" value="" class="input-field" required></div>

    <div><label for="password">Пароль</label></div>
    <div><input name="password" type="password" value="" class="input-field" required minlength="8"></div>

    <div><input type="submit" name="submit" value="Логин" class="form-submit-button"></span></div>
    <div><a class="btn btn-primary mt-3" href="<?php echo strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://'.$_SERVER['SERVER_NAME'].'/register'?>">Регистрация</a></div>

</form>
