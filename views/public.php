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
            <p></p>
        </div>
    </div>
</div>




<script>
    const hasChildIcons = document.querySelectorAll('#items-panel .item .has-childs-icon');
    hasChildIcons.forEach(function(hasChildIcon) {
        hasChildIcon.addEventListener('click', function() {
            let item = this.closest(".item");
            if(item.classList.contains('show')) {
                item.classList.remove('show');
                let childItems = item.querySelectorAll('.item');
                if(childItems) {
                    childItems.forEach(function (childItem){
                        childItem.classList.remove('show');
                    })
                }
            } else {
                item.classList.add('show');
            }
        })
    })

    const ItemTitles = document.querySelectorAll('#items-panel .item .item-title');
    const paragraphDescription = document.querySelector('.block-description .popup-description p');
    const blockDescription = document.querySelector('.block-description .popup-description');
    const itemsColumn = document.querySelector('#items-panel .items-column');

    ItemTitles.forEach(function(ItemTitle) {
        ItemTitle.addEventListener('click', function () {
            paragraphDescription.textContent = this.dataset.description;
            blockDescription.classList.add('visible');
        })
    })

    document.addEventListener( 'click', (e) => {
        const withinBoundaries = e.composedPath().includes(blockDescription);
        const withinItemsColumn = e.composedPath().includes(itemsColumn);

        if ( ! withinBoundaries && !withinItemsColumn) {
            blockDescription.classList.remove('visible');
        }
    })

    // item-description
</script>

<?php
include ROOT . '/views/templates/footer.php';
?>
