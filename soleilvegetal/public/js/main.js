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

window.filter = function () {
    return {
        filter_form: null,
        showAutor: false,
        showTechnique: false,
        filteredAutors: [],
        filteredTechniques: [],
        init: function () {
            this.filter_form = this.$refs.filter_form;
            console.log('Working filter... >--O');
        },
        checkSwap: function (e) {
            filterArrays = {'autor': this.filteredAutors, 'technique': this.filteredTechniques};
            let [type, id] = e.target.id.split('_');
            if (e.target.checked) {
                let index = filterArrays[type].indexOf(id);
                filterArrays[type].splice(index, 1);
            } else {
                filterArrays[type].push(id);
            }
        },
        filter: function (e) {
            e.preventDefault();
            if (this.filteredAutors.length > 0 || this.filteredTechniques.length > 0) {
                let filtered_autors = this.filteredAutors.length > 0 ? this.filteredAutors.join('&') : '0';
                let url = this.filter_form.action.replace('ids', filtered_autors) + '/' + this.filteredTechniques.join('&');
                this.filter_form.action = url;
                this.filter_form.submit();
            }

            this.showAutor = false;
            this.showTechnique = false;
        }
    }
}
