(function() {
    const tagsInput = document.querySelector('#tags_input');

    if(tagsInput) {

        const tagsDiv = document.querySelector('#tags');
        const tagsInputHidden = document.querySelector('[name="tags"]');

        let tags = [];

        if(tagsInputHidden.value !== '') {
            tags = tagsInputHidden.value.split(',');
            showTags();
        }

        tagsInput.addEventListener('keypress', saveTag);

        function saveTag(e) {
            if(e.keyCode === 44) { // Keycode
                
                if(e.target.value.trim() === '' || e.target.value < 1) {
                    return;
                }
                e.preventDefault();

                tags = [...tags, e.target.value.trim()];

                tagsInput.value = '';

                showTags();
            }
        }

        function showTags() {
            tagsDiv.textContent = '';

            tags.forEach(tag => {
                const newTag = document.createElement('LI');
                newTag.classList.add('form__tag');
                newTag.textContent = tag;
                newTag.ondblclick = removeTag;
                tagsDiv.appendChild(newTag);
            })

            updateHiddenInput();
        }

        function removeTag(e) {
            e.target.remove();
            tags = tags.filter(tag => tag !== e.target.textContent);
            updateHiddenInput();
        }

        function updateHiddenInput() {
            tagsInputHidden.value = tags.toString();
        }
    }
})()