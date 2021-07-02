window.cartItem = function () {
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
        autors_ul: null,
        techniques_ul: null,
        show_autor: false,
        show_technique: false,
        filtered_autors: [],
        filtered_techniques: [],
        init: function () {
            if (localStorage.getItem('filtered_autors')) {
                if (window.location.pathname.search('filter') != -1) {
                    this.filtered_autors = JSON.parse(localStorage.filtered_autors);
                    this.filtered_techniques = JSON.parse(localStorage.filtered_techniques);
                } else {
                    localStorage.removeItem('filtered_autors');
                    localStorage.removeItem('filtered_techniques');
                }
            }
            this.filter_form = this.$refs.filter_form;
            this.autors_ul = this.$refs.autors;
            this.techniques_ul = this.$refs.techniques;
            this.updateDOM();
        },
        updateDOM: function() {
            this.filtered_autors.forEach(function (filtered_autor) {
                let autors_ul = document.querySelector('#autor_' + filtered_autor);
                if (autors_ul) {
                    autors_ul.checked = false;
                }
            });
            this.filtered_techniques.forEach(function (filtered_technique) {
                let techniques_ul = document.querySelector('#technique_' + filtered_technique);
                if (techniques_ul) {
                    techniques_ul.checked = false;
                }
            });
        },
        checkSwap: function (e) {
            filterArrays = {'autor': this.filtered_autors, 'technique': this.filtered_techniques};
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
            if (this.filtered_autors.length > 0 || this.filtered_techniques.length > 0) {
                let filtered_autors = this.filtered_autors.length > 0 ? this.filtered_autors.join('&') : '0';
                let url = this.filter_form.action.replace('ids', filtered_autors) + '/' + this.filtered_techniques.join('&');
                this.filter_form.action = url;
                localStorage.setItem('filtered_autors', JSON.stringify(this.filtered_autors));
                localStorage.setItem('filtered_techniques', JSON.stringify(this.filtered_techniques));
                this.filter_form.submit();
            }
            this.show_autor = false;
            this.show_technique = false;
        }
    }
}
