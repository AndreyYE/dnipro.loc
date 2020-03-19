<?php
$contacts = new \app\entity\Contacts($env);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contacts->add_contact_to_user();
    return true;
}
?>
<?php if(!isset($contacts->index()['errors'])):?>
    <h3 class="text-center text-warning">Контакты</h3>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Имя</th>
        <th scope="col">Телефон</th>
        <th scope="col">Добавить в избранное</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($contacts->index() as $val):?>
    <tr>
        <th scope="row"><?php echo $val['id']?></th>
        <td><?php echo $val['name']?></td>
        <td><?php echo $val['phone']?></td>
        <td>
            <form action="" class="addFavor">
                <input name="id" type="hidden" value="<?php echo $val['id']?>">
                <button class="btn btn-success" type="submit">Добавить</button>
            </form></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div>Посмотреть избранное - <a class="btn btn-primary" href="<?php echo strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://'.$_SERVER['SERVER_NAME'].'/favorites'?>">Избранные</a></div>
<?php else:?>
<div>Нет ни одного контакта (Возможно вы добавили уже все контакты. Перейдите по ссылке чтобы в этом убедиться) -
    <a class="btn btn-primary" href="<?php echo strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://'.$_SERVER['SERVER_NAME'].'/favorites'?>">Избранные</a></div>
<?php endif;?>  