<?php
include ROOT . '/views/templates/header.php';
?>

<div class="public-container">
    <div id="items-panel">
        <div class="items-column">
            <?php
            $used_items = array();
            foreach($items as $item) {
                if(in_array($item['id'], $used_items)) {
                    continue;
                }
                $hasChilds = !empty($item['childs']) ? 'has-childs' : '';
                ?>
                <div class="item <?php echo $hasChilds; ?>">
                    <div class="item-title" data-description="<?php echo $item['description']; ?>"><?php echo $item['title']; ?></div>
                    <?php if($hasChilds) { ?>
                        <span class="has-childs-icon"></span>
                    <?php } ?>
                    <?php
                    array_push($used_items, $item['id']);
                    if(!empty($item['childs'])) {
                        ItemController::printItemPublic($items, $used_items, $item['childs']);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="block-description">
        <div class="popup-description">
            <div class="popup-description-close"></div>
            <p></p>
        </div>
    </div>
</div>

<script src="/assets/js/public.js"></script>

<?php
include ROOT . '/views/templates/footer.php';
?>
