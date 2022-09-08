<?php

require_once ROOT . '/models/Item.php';

class ItemController {

    public function index()
    {
        $items = Item::getItems();
        include ROOT . '/views/index.php';
    }
    public function addItem()
    {

        $item_title = '';
        if(isset($_POST['item_title']) && !empty($_POST['item_title'])) {
            $item_title = $_POST['item_title'];
        }

        $item_description = '';
        if(isset($_POST['item_description']) && !empty($_POST['item_description'])) {
            $item_description = $_POST['item_description'];
        }

        $item_parent = null;
        if(isset($_POST['item_parent']) && !empty($_POST['item_parent'])) {
            $item_parent = $_POST['item_parent'];
        }

        Item::addItem($item_title, $item_description, $item_parent);
    }

    public function editItem()
    {

        $item_id = '';
        if(isset($_POST['item_id']) && !empty($_POST['item_id'])) {
            $item_id = $_POST['item_id'];
        }

        $item_title = '';
        if(isset($_POST['item_title']) && !empty($_POST['item_title'])) {
            $item_title = $_POST['item_title'];
        }

        $item_description = '';
        if(isset($_POST['item_description']) && !empty($_POST['item_description'])) {
            $item_description = $_POST['item_description'];
        }

        $new_item_parent = null;
        if(isset($_POST['item_parent']) && !empty($_POST['item_parent'])) {
            $new_item_parent = $_POST['item_parent'];
        }

        $old_parent_id = null;
        if(isset($_POST['old_parent_id']) && !empty($_POST['old_parent_id'])) {
            $old_parent_id = $_POST['old_parent_id'];
        }

        if($new_item_parent != $old_parent_id && $new_item_parent != $item_id) {
            Item::updateParents($old_parent_id, $new_item_parent, $item_id);
            Item::updateChilds( $item_id );
        }

        Item::updateItem($item_id, $item_title, $item_description, $new_item_parent);
    }

    public function deleteItem()
    {
//        echo "<pre>";
//        print_r( $_POST );
//        echo "</pre>";

        $itemId = $_GET['id'];
        Item::deleteRecursive($itemId);



    }
}
