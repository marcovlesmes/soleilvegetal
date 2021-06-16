window.cardItem = function () {
    return {
        count: null,
        deleteForm: null,
        deleteInput: null,
        formData: {
            user_id: null,
            item_id: null,
        },
        init() {
            this.deleteForm = this.$refs.deleteForm;
            this.deleteInput = document.getElementById('delete-input');
            this.count = document.getElementsByClassName('item-cart').length;
        },
        destroy(id) {
            this.count--;
            this.deleteInput.value = id;
            const item = document.getElementById('item-'+id);
            item.remove();
            this.deleteForm.submit();
        }
    }
}

window.imageSwitcher = function () {
    return {
        mainContainer: null,
        init() {
            this.mainContainer = this.$refs.mainContainer;
        },
        swapImage(id) {
            thumb = document.getElementById('thumb-' + id);
            image = document.createElement('img');
            image.src = thumb.src;
            image.setAttribute('class','max-h-full min-w-full object-cover align-botton');
            this.mainContainer.innerHTML = '';
            this.mainContainer.appendChild(image);
        }
    }
}