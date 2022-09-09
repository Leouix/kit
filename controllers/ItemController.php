<?php

require_once ROOT . '/models/Item.php';

class ItemController {

    public static function index()
    {
        $items = Item::getItems();
        include ROOT . '/views/admin.php';
    }

    public static function publicPanel()
    {
        $items = Item::getItems();
        include ROOT . '/views/public.php';
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
        $itemId = $_GET['id'];
        Item::deleteRecursive($itemId);
    }

    public static function printItem( & $items, & $used_items, $itemChilds, $ml=10 ) {
        $arrayItems = explode(',', $itemChilds);
        foreach($arrayItems as $item_id) {
            if(in_array($item_id, $used_items)) {
                continue;
            }
            $item = $items[$item_id];
            ?>
            <div class="item" style="margin-left:<?php echo $ml; ?>px" data-parent="<?php echo $item['parent']; ?>" data-childs="<?php echo $item['childs']; ?>" data-id="<?php echo $item['id']; ?>">
                <div class="item-buttons">
                    <div class="item-id">#<?php echo $item['id']; ?></div>
                    <div class="edit-button"></div>
                    <a href="/delete-item?id=<?php echo $item['id']; ?>" class="delete-button"></a>
                </div>

                <div class="item-title"><?php echo $item['title']; ?></div>
                <div class="item-description"><?php echo $item['description']; ?></div>
                <?php
                array_push($used_items, $item_id);
                if(!empty($item['childs'])) {
                    self::printItem($items, $used_items, $item['childs']);
                }
                ?>
            </div>
            <?php
        }
    }

    public static function printItemPublic( & $items, & $used_items, $itemChilds, $ml=10 ) {
        $arrayItems = explode(',', $itemChilds);
        foreach($arrayItems as $item_id) {
            if(in_array($item_id, $used_items)) {
                continue;
            }
            $item = $items[$item_id];
            $hasChilds = !empty($item['childs']) ? 'has-childs' : '';
            ?>
            <div class="item <?php echo $hasChilds; ?>" style="margin-left:<?php echo $ml; ?>px;" >
                <div class="item-title" data-description="<?php echo $item['description']; ?>"><?php echo $item['title']; ?> </div>
                <?php if($hasChilds) { ?>
                    <span class="has-childs-icon"></span>
                <?php } ?>
                <?php
                array_push($used_items, $item_id);
                if(!empty($item['childs'])) {
                    self::printItemPublic($items, $used_items, $item['childs']);
                }
                ?>
            </div>
            <?php
        }
    }
}
