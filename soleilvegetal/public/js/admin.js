window.listedItems = function () {
    return {
        itemsContainer : null,
        saveListBtn: null,
        checkInputs: [],
        initCheckValues: null,
        setForm: null,
        destroyForm: null,
        destroyUrl: null,
        init: function () {
            this.itemsContainer = this.$refs.itemsContainer;
            this.saveListBtn = this.$refs.saveListBtn;
            this.itemsContainer.childNodes.forEach(element => {
                if (element.childElementCount > 0) {
                    this.checkInputs.push(element.querySelector('input[type=checkbox]'));
                }
            });
            this.initCheckValues = this.getCheckValues();
            this.setForm = this.$refs.setForm;
            this.destroyForm = this.$refs.destroyForm;
            this.destroyUrl = this.destroyForm.action.slice(0, -1);
            this.checkChanges();
        },
        checkChanges: function () {
            let actuallyState = this.getCheckValues();
            if (JSON.stringify(actuallyState) == JSON.stringify(this.initCheckValues)) {
                this.saveListBtn.disabled = true;
            } else {
                this.saveListBtn.disabled = false;
            }
        },
        destroy: function (id) {
            this.destroyForm.setAttribute('action', this.destroyUrl + id)
            this.destroyForm.submit();
        },
        getCheckValues: function () {
            let values = {};
            this.checkInputs.forEach(input => {
                if (input) {
                    values[input.id.replace('checkbox-', '')] = input.checked;
                }
            });
            return values;
        },
        setCarousel: function () {
            console.log(this.setForm);
            this.setForm.querySelector('input#setter').value = JSON.stringify(this.getCheckValues());
            this.setForm.submit();
        }
    }
}

window.modelManager = function () {
    return {
        dataForm: null,
        init: function () {
            this.dataForm = this.$refs.dataForm;
            this.update();
        },
        update: function () {
            let selectFields = document.querySelectorAll('select')
            for (let i = 0; i < selectFields.length; i++) {
                this.setSelectField(selectFields[i]);
            }
        },
        checkOption: function (e) {
            let field = e.target;
            this.setSelectField(field);
        },
        save: function () {
            this.dataForm.submit();
        },
        setSelectField: function (field) {
            let label = field.nextElementSibling.querySelector('label');
            let input = field.nextElementSibling.querySelector('input');
            if (field.value == 'new') {
                label.classList.remove('text-gray-300');
                input.classList.remove('text-gray-400');
                input.disabled = false;
            } else {
                label.classList.add('text-gray-300');
                input.classList.add('text-gray-400');
                input.disabled = true;
            }
        }
    }
}