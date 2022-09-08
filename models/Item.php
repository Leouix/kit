<?php

require_once ROOT . '/components/DB.php';

class Item {

    public static function getItems( $orderby=' ORDER BY parent ASC' ) {
        $db = DB::getConnection();
        $sql = "SELECT * FROM `items` $orderby";
        $stm = $db->query($sql);
        $itemsArray = $stm->fetchAll(PDO::FETCH_ASSOC);

        $result = array();
        foreach($itemsArray as $item) {
            $result[$item['id']] = $item;
        }
        return $result;
    }

    public static function addItem( $title, $desciption, $parent ) {
        if( !is_null($parent) && !self::checkItemInDb($parent)) {
            $parent = null;
        }
        $db = DB::getConnection();
        $sql = "INSERT INTO `items` (`title`, `description`, `parent`) VALUES ( ?, ?, ? )";
        $stmt= $db->prepare($sql);
        if($stmt->execute([$title, $desciption, $parent ]) && !is_null($parent)) {
            $newItem = $db->lastInsertId();
            self::updateChildsItem($parent, $newItem );
        }
        header('location: /');
    }

    public static function getItem($itemId) {
        $db = DB::getConnection();
        $sql = "SELECT * FROM `items` WHERE id = $itemId";
        $stm = $db->query($sql);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    protected static function checkItemInDb($itemId) {
        if(is_null($itemId)) return false;
        try {
            $db = DB::getConnection();
            $sql = "SELECT id FROM `items` WHERE id = $itemId";
            $stm = $db->query($sql);
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }

    }

    public static function updateChildsItem( $parentId, $childId ) {

        $response = array (
            'error' => '',
            'success' => ''
        );

        if(is_null($parentId)) {
            $response['error'] =  __FUNCTION__  . ' Parent Id is empty';
            echo "<pre>";
            print_r( $response );
            echo "</pre>";
            return $response;
        }

        if( ! self::checkItemInDb($parentId)) {
            $response['error'] =  __FUNCTION__ . ' Parent is not exists';
            echo "<pre>";
            print_r( $response );
            echo "</pre>";
            return $response;
        }

        $db = DB::getConnection();
        $itemParent = self::getItem($parentId);

        $childsItem = array();
        if(!empty($itemParent[0]['childs'])) {
            $childsItem = explode(',', $itemParent[0]['childs']);
        }

        array_push( $childsItem, $childId);

        $childs = implode(',', $childsItem);
        $sql = "UPDATE `items` SET `childs`=? WHERE `id`=?";
        $stmt= $db->prepare($sql);
        $stmt->execute([$childs, $parentId]);
//        header('location:' . $_SERVER['REQUEST_URI'] );
    }

    public static function removeChildId($parentId, $removingChild)
    {
        $response = array(
            'error' => '',
            'success' => '',
        );

        if(is_null($parentId)) {
            $response['error'] = 'Parent id is null';
            return $response;
        }

        if( ! self::checkItemInDb($parentId)) {
            $response['error'] = __FUNCTION__ . ' Parent is not exists';
            echo "<pre>";
            print_r( $response );
            echo "</pre>";
            return $response;
        }

        $db = DB::getConnection();
        $itemParent = self::getItem($parentId);

        if(!empty($itemParent[0]['childs'])) {
            $childsItem = explode(',', $itemParent[0]['childs']);
        } else {
            $response['error'] = 'Parent childs ic not exixts';
            return $response;
        }

        if (($key = array_search( $removingChild, $childsItem)) !== false) {
            unset($childsItem[$key]);
        } else {
            $response['error'] = 'Array kay was not found';
            return $response;
        }

        $childs = implode(',', $childsItem);
        $sql = "UPDATE `items` SET `childs`=? WHERE `id`=?";
        $stmt= $db->prepare($sql);
        $stmt->execute([$childs, $parentId]);

        $response['success'] = true;
        return $response;
    }

    public static function updateItem($id, $title, $description, $newParent) {
        if( ! self::checkItemInDb($newParent)) {
            $newParent = null;
        }
        $db = DB::getConnection();
        $sql = "UPDATE `items` SET `title`=?, `description`=?, `parent`=? WHERE `id`=?";
        $stmt= $db->prepare($sql);
        $stmt->execute([$title, $description, $newParent, $id]);
        header('location: /');
    }

    public static function removeItem($itemId) {

        $db = DB::getConnection();

        try {
            $sql = "DELETE FROM `items` WHERE `id` =?";
            $stmt= $db->prepare($sql);
            $stmt->execute([$itemId]);
        }
        catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }

//        header('location: /');
    }

    public static function deleteRecursive($itemId, $childIds = '') {

        $db = DB::getConnection();
        $sql = "SELECT * FROM `items` WHERE id = $itemId";
        $stm = $db->query($sql);
        $item = $stm->fetchAll(PDO::FETCH_ASSOC);

        Item::removeItem($itemId);
        if(!empty($item[0]['parent'])) {
            Item::removeChildId($item[0]['parent'], $itemId);
        }

        if( !empty($item[0]['childs'])) {

            if(!empty($childIds)) {
                $childIds .= ',';
            }
            $childIds .= $item[0]['childs'];

            $childsArray = explode(',', $item[0]['childs']);
            foreach($childsArray as $childId) {
                return self::deleteRecursive($childId, $childIds);
            }
        }

        header('location: /');
    }

    public static function checkHeirs($itemId, $parentId) {
        // $item не может иметь дочерних элементов, которые родители его родителя
        $item = self::getItem($itemId);
        $itemChilds = $item[0]['childs'];
        if(empty($itemChilds)) return true;

        $itemChildsArray = explode(',', $itemChilds);

        return self::checkParentsHeirsRecursive($parentId, $itemId, $itemChildsArray);

    }

    protected static function checkParentsHeirsRecursive($parentId, $itemId, $itemChildsArray) {
        $parentItem = self::getItem($parentId);
        $parentParent_id = $parentItem[0]['parent'];
        if(empty($parentParent_id)) return true;

        if(in_array($parentParent_id, $itemChildsArray)) {
            self::removeChildId($itemId, $parentParent_id);
            return true;
        } else {
            return self::checkParentsHeirsRecursive($parentParent_id, $itemId, $itemChildsArray);
        }

    }

    public static function updateParents($old_parent_id, $new_item_parent, $item_id)
    {
        self::removeChildId($old_parent_id, $item_id);
        self::updateChildsItem( $new_item_parent, $item_id );
    }

    public static function updateChilds($itemId)
    {
        self::removeHisParentFormOldChilds($itemId);
        self::removeAllChilds($itemId);
    }

    protected static function removeHisParentFormOldChilds($itemId) {
        $db = DB::getConnection();
        $sql = "SELECT id FROM `items` WHERE parent = $itemId";
        $stm = $db->query($sql);
        $itemIds = $stm->fetchAll(PDO::FETCH_ASSOC);

        echo "<pre>";
        print_r( $itemIds );
        echo "</pre>";

        if(!empty($itemIds[0])) {
            foreach($itemIds[0] as $itemId) {

                echo "<pre>";
                print_r( $itemId );
                echo "</pre>";

                self::updateParent($itemId, null);
            }
        }
    }

    protected static function updateParent($itemId, $parentId) {
        $db = DB::getConnection();
        $sql = "UPDATE `items` SET `parent`=? WHERE `id`=?";
        $stmt= $db->prepare($sql);
        $stmt->execute([$parentId, $itemId]);
    }

    protected static function removeAllChilds($itemId) {
        $db = DB::getConnection();
        $sql = "UPDATE `items` SET `childs`=? WHERE `id`=?";
        $stmt= $db->prepare($sql);
        $stmt->execute([null, $itemId]);
    }

}
