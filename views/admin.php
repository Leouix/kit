<?php
include ROOT . '/views/templates/header.php';
?>

<div class="admin-panel">

    <?php
    $used_items = array();
    foreach($items as $item) {
        if(in_array($item['id'], $used_items)) {
            continue;
        }
        ?>
        <div class="item" data-parent="<?php echo $item['parent']; ?>" data-childs="<?php echo $item['childs']; ?>" data-id="<?php echo $item['id']; ?>">
            <div class="item-buttons">
                <div class="edit-button"></div>
                <a href="/delete-item?id=<?php echo $item['id']; ?>" class="delete-button"></a>
            </div>
            <div class="item-id"><?php echo $item['id']; ?></div>
            <div class="item-title"><?php echo $item['title']; ?></div>
            <div class="item-description"><?php echo $item['description']; ?></div>
            <?php
            array_push($used_items, $item['id']);
            if(!empty($item['childs'])) {
                ItemController::printItem($items, $used_items, $item['childs']);
            }
            ?>
        </div>
        <?php
    }

    ?>

    <div class="add-root-el">
        <img src="/images/add.png" alt="">
    </div>
</div>

<div class="popup-wrapper">
    <div class="popup-add">
        <h3>Добавить элемент структуры</h3>
        <form id="form-add-item" action="/add-item" method="post">
            <div class="form-group">
                <label for="add-item__title">Заголовок</label>
                <input id="add-item__title" type="text" name="item_title">
            </div>
            <div class="form-group">
                <label for="add-item__description">Описание</label>
                <textarea id="add-item__description" rows="5" name="item_description"></textarea>
            </div>
            <div class="form-group">
                <label for="add-item__parent">Родительский элемент</label>
                <input id="add-item__parent" type="number" name="item_parent">
            </div>
            <input type="submit" value="Сохранить">
        </form>
    </div>
</div>

<div class="edit-items-wrapper">
    <div class="edit-items-window">
        <h3>Редактировать элемент структуры</h3>
        <form id="edit-form" action="/edit-item" method="post">
            <div class="id-item">ID элемента: <span></span></div>
            <div class="form-group">
                <label for="edit-item_title">Заголовок</label>
                <input id="edit-item_title" type="text" name="item_title">
            </div>
            <div class="form-group">
                <label for="edit-item_description">Описание</label>
                <textarea id="edit-item_description" rows="5" name="item_description"></textarea>
            </div>
            <div class="form-group">
                <label for="edit-item_parent">Родительский элемент</label>
                <input id="edit-item_parent" type="number" name="item_parent">
            </div>
            <input id="edit-item_id" type="hidden" name="item_id" value="">
            <input id="edit-old_parent_id" type="hidden" name="old_parent_id" value="">
            <input type="submit" value="Сохранить">
        </form>
    </div>
</div>

<script src="/assets/js/script.js"></script>

<?php
include ROOT . '/views/templates/footer.php';
?>


<?php

//echo "<pre>";
//print_r( $items );
//echo "</pre>";

?>
