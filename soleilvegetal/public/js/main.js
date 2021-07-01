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

window.sidebar = function () {
    return {
        search_form: null,
        init: function () {
            this.search_form = this.$refs.search_form;
            console.log('Working sidebar! :[O');
        },
        submit_form: function (e) {
            e.preventDefault();
            let keywork = this.search_form.querySelector('input').value;
            if (keywork.length > 0) {
                this.search_form.action = this.search_form.action.replace('keywork', keywork);
                this.search_form.submit();
            }
        }
    }
}
