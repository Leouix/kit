window.addEventListener('DOMContentLoaded', function() {

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

            popupAddForm.classList.remove('active');
            editWrapper.classList.add('active');
            editFormTitle.focus();
        })
    })

    const addRootButton = document.querySelector(".add-root-el");
    const popupAddForm = document.querySelector(".popup-wrapper");
    const adminPanel = document.querySelector(".admin-panel");
    const addFormTitle = document.querySelector("#add-item__title");
    addRootButton.addEventListener('click', function() {
        editWrapper.classList.remove('active');
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

    const closeAddPanelIcon = document.querySelector(".popup-wrapper-close");
    closeAddPanelIcon.addEventListener('click', function () {
        popupAddForm.classList.remove('active');
    })

    const closeEditPanelIcon = document.querySelector(".edit-items-close");
    closeEditPanelIcon.addEventListener('click', function () {
        editWrapper.classList.remove('active');
    })

})


