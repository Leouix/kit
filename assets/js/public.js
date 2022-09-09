window.addEventListener('DOMContentLoaded', function() {

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

    const popupDescriptionCloseIcon = document.querySelector('.popup-description-close');
    popupDescriptionCloseIcon.addEventListener('click', function() {
        blockDescription.classList.remove('visible');
    })
})

