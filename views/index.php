<?php

function printItem( & $items, & $used_items, $itemChilds, $ml=10) {
    $arrayItems = explode(',', $itemChilds);
    foreach($arrayItems as $item_id) {
        if(in_array($item_id, $used_items)) {
            continue;
        }
        $item = $items[$item_id];
        ?>
        <div class="item" style="margin-left:<?php echo $ml; ?>px" data-parent="<?php echo $item['parent']; ?>" data-childs="<?php echo $item['childs']; ?>" data-id="<?php echo $item['id']; ?>">
            <div class="item-buttons">
                <div class="edit-button"></div>
                <a href="/delete-item?id=<?php echo $item['id']; ?>" class="delete-button"></a>
            </div>
            <div class="item-id"><?php echo $item['id']; ?></div>
            <div class="item-title"><?php echo $item['title']; ?></div>
            <div class="item-description"><?php echo $item['description']; ?></div>
            <?php
            array_push($used_items, $item_id);
            if(!empty($item['childs'])) {
                printItem($items, $used_items, $item['childs']);
            }
            ?>
        </div>
        <?php
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

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
                    printItem($items, $used_items, $item['childs']);
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

<script>

    const editButtons = document.querySelectorAll(".edit-button");
    const editWrapper = document.querySelector(".edit-items-wrapper");

    const editForm = document.querySelector("#edit-form");
    const editFormTitle = editForm.querySelector("#edit-item_title");
    const editFormDescription = editForm.querySelector("#edit-item_description");
    const editFormParent = editForm.querySelector("#edit-item_parent");
    const editFormId = editForm.querySelector("#edit-item_id");
    const editOldParentId = editForm.querySelector("#edit-old_parent_id");
    const idEl = editForm.querySelector('.id-item span');

    editButtons.forEach(function(editButton) {
        editButton.addEventListener('click', function() {

            const item = this.closest('.item');
            const itemParent = item.dataset.parent;
            const itemId = item.dataset.id;
            const itemTitle = item.querySelector('.item-title').textContent;
            const itemDescription = item.querySelector('.item-description').textContent;

            editFormTitle.value = itemTitle;
            editFormDescription.value = itemDescription;
            editFormParent.value = itemParent;
            editOldParentId.value = itemParent;
            editFormId.value = itemId;
            idEl.textContent = itemId;

            editWrapper.classList.add('active');
            editFormTitle.focus();
        })
    })

    const addRootButton = document.querySelector(".add-root-el");
    const popupAddForm = document.querySelector(".popup-wrapper");
    const adminPanel = document.querySelector(".admin-panel");
    const addFormTitle = document.querySelector("#add-item__title");
    addRootButton.addEventListener('click', function() {
        popupAddForm.classList.add('active');
        addFormTitle.focus();
    })

    document.addEventListener( 'click', (e) => {
        const withinBoundaries = e.composedPath().includes(popupAddForm);
        const withinadminPanel = e.composedPath().includes(adminPanel);

        if ( ! withinBoundaries && !withinadminPanel) {
            popupAddForm.classList.remove('active');
        }
    })

    document.addEventListener( 'click', (e) => {
        const withinBoundaries = e.composedPath().includes(editWrapper);
        const withinadminPanel = e.composedPath().includes(adminPanel);

        if ( ! withinBoundaries && !withinadminPanel) {
            editWrapper.classList.remove('active');
        }
    })

</script>

<style>
    body, html {
        margin: 0;
        width: 100%;
        height: 100%;
    }
    .admin-panel {
        height: 100%;
        width: 300px;
        margin-right: auto;
        background: #74749a;
    }
    .add-root-el {
        width: 100%;
        height: 50px;
        border: 3px solid #ababb3;
        display: flex;
        justify-content: center;
        align-items: center;
        box-sizing: border-box;
    }
    .add-root-el img {
        width: 25px;
    }

    .popup-add {
        width: 300px;
        margin: 0 35px;
    }
    .popup-wrapper {
        position: fixed;
        top: 0;
        right: 0;
        width: 0;
        height: 100%;
        transition: 0.35s ease-in;
        padding: 35px 0;
        box-shadow: -1px 0px 3px 0px #0000003d;
        background: #e9e9e9;
    }

    .popup-wrapper.active {
        width: 335px;
        padding-right: 35px;
    }

    .form-group label {
        display: block;
    }

    .form-group {
        width: 100%;
        box-sizing: border-box;
    }

    .form-group input {
        width: 100%;
        box-sizing: border-box;
    }

    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
    }

    .admin-panel .item {
        position: relative;
        border: 1px solid #9a9999;
        background: #ccc;
    }

    .edit-items-wrapper {
        position: fixed;
        top: 0;
        right: 0;
        width: 0;
        height: 100%;
        transition: 0.35s ease-in;
        padding: 35px 0;
        box-shadow: -1px 0px 3px 0px #0000003d;
        background: #e9e9e9;
    }
    .edit-items-wrapper.active {
        width: 335px;
        padding-right: 35px;
    }
    .edit-items-window {
        width: 300px;
        margin: 0 35px;
    }

    .admin-panel .item-buttons {
        position: absolute;
        top: 5px;
        right: 5px;
        display: flex;
    }

    .admin-panel .edit-button {
        background: url('/images/edit.png');
        background-size: cover;
        width: 20px;
        height: 20px;
        margin: 0 5px;
    }
    .admin-panel .delete-button {
        background: url('/images/delete.png');
        background-size: cover;
        width: 20px;
        height: 20px;
        margin: 0 5px;
    }
</style>
</body>



</html>

<?php

//echo "<pre>";
//print_r( $items );
//echo "</pre>";

?>
