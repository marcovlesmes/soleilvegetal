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
            const item = document.getElementById('item-' + id);
            item.remove();
            this.deleteForm.submit();
        }
    }
}

window.imageSwitcher = function () {
    return {
        currentXZoomZone: null,
        currentYZoomZone: null,
        image: null,
        imageHeight: null,
        imageWidth: null,
        mainContainer: null,
        viewer: null,
        zoomZone: null,
        init: function () {
            this.mainContainer = this.$refs.mainContainer;
            this.zoomZone = this.$refs.zoomZone;
            this.image = this.$refs.image;
            this.viewer = this.$refs.viewer;
        },
        swapImage: function (id) {
            thumb = document.getElementById('thumb-' + id);
            this.mainContainer.querySelector('img').src = thumb.src;
        },
        initZoomImage: function (e) {
            if (!this.imageWidth) {
                this.imageWidth = e.target.width;
                this.imageHeight = e.target.height;
                this.zoomWidth = this.imageWidth / 2;
                this.zoomHeight = this.imageHeight / 2;
            }
            this.zoomZone.classList.remove('hidden');
            this.viewer.classList.remove('hidden');
        },
        zoomTo: function (e) {
            let zeroX = this.image.getBoundingClientRect().left;
            let zeroY = this.image.getBoundingClientRect().top + window.scrollY;
            let mouseX = e.clientX;
            let mouseY = e.clientY;
            let half_zoomZoneHeight = this.zoomHeight / 2;
            let half_zoomZoneWidth = this.zoomWidth / 2;

            if (mouseX > zeroX + half_zoomZoneWidth && mouseX < zeroX + this.imageWidth - half_zoomZoneWidth) {
                this.currentXZoomZone = mouseX - half_zoomZoneWidth;
            }
            if (mouseY > zeroY + half_zoomZoneHeight && mouseY < zeroY + this.imageHeight - half_zoomZoneHeight) {
                this.currentYZoomZone = mouseY - half_zoomZoneHeight;
            } 
            this.zoomZone.setAttribute(
                'style',
                'top:' + this.currentYZoomZone + 'px;left:' + this.currentXZoomZone + 'px;width:' + this.zoomWidth + 'px;height:' + this.zoomHeight + 'px;'
            );
            this.viewer.setAttribute(
                'style',
                'width:' + this.imageWidth + 'px;height:' + (this.imageHeight) + 'px;background:url("' + this.image.src + '") no-repeat;padding:5px;background-size:' + this.imageWidth * 2 + 'px ' + this.imageHeight * 2 + 'px;background-position:-' + ((this.currentXZoomZone - zeroX) * 2) + 'px -' + ((this.currentYZoomZone - zeroY) * 2) + 'px;'
                );
        },
        killZoomImage: function () {
            this.zoomZone.classList.add('hidden');
            this.viewer.classList.add('hidden')
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
        autors_ul: null,
        checkingAutors: true,
        checkingTechniques: true,
        filter_form: null,
        filtered_autors: [],
        filtered_techniques: [],
        show_autor: false,
        show_technique: false,
        techniques_ul: null,
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
        toggleAutorCheckbox: function (e) {
            e.preventDefault();
            let checkboxes = this.autors_ul.querySelectorAll('input[type=checkbox]');
            if (this.checkingAutors) {
                this.filtered_autors = [];
                checkboxes.forEach((checkbox) => {
                    this.filtered_autors.push(checkbox.id.split('_')[1]);
                    checkbox.checked = false;
                });
                e.target.textContent = 'Seleccionar todos';
                this.checkingAutors = false;
            } else {
                checkboxes.forEach((checkbox) => {
                    this.filtered_autors = [];
                    checkbox.checked = true;
                });
                e.target.textContent = 'Deseleccionar todos';
                this.checkingAutors = true;
            }
        },
        toggleTechniqueCheckbox: function (e) {
            e.preventDefault();
            let checkboxes = this.techniques_ul.querySelectorAll('input[type=checkbox]');
            if (this.checkingTechniques) {
                this.filtered_techniques = [];
                checkboxes.forEach((checkbox) => {
                    this.filtered_techniques.push(checkbox.id.split('_')[1]);
                    checkbox.checked = false;
                });
                e.target.textContent = 'Seleccionar todos';
                this.checkingTechniques = false;
            } else {
                checkboxes.forEach((checkbox) => {
                    this.filtered_techniques = [];
                    checkbox.checked = true;
                });
                e.target.textContent = 'Deseleccionar todos';
                this.checkingTechniques = true;
            }
        },
        updateDOM: function () {
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
            filterArrays = { 'autor': this.filtered_autors, 'technique': this.filtered_techniques };
            let [type, id] = e.target.id.split('_');
            // If was checked
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
