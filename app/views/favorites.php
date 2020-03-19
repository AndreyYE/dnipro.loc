<?php
$fav = new \app\entity\Favorites($env);
$favorities = $fav->getAllFavorites();
?>
<?php if(!isset($favorities['errors'])):?>
    <h3 class="text-center text-warning">Избранное</h3>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Имя</th>
            <th scope="col">Телефон</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($favorities as $val):?>
            <tr>
                <th scope="row"><?php echo $val['id']?></th>
                <td><?php echo $val['name']?></td>
                <td><?php echo $val['phone']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div>Посмотреть все контакты - <a class="btn btn-primary" href="<?php echo strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://'.$_SERVER['SERVER_NAME'].'/contacts'?>">Контакты</a></div>
<?php else:?>
    <div>Нет ни одного избранного контакты, перейдите по ссылке что бы добавить контакты в избранное -
        <a class="btn btn-primary" href="<?php echo strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://'.$_SERVER['SERVER_NAME'].'/contacts'?>">Контакты</a></div>
<?php endif;?>