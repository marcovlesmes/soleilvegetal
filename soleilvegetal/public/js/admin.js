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
            if (this.itemsContainer) {
                this.itemsContainer.childNodes.forEach(element => {
                    if (element.childElementCount > 0) {
                        this.checkInputs.push(element.querySelector('input[type=checkbox]'));
                    }
                });
                this.initCheckValues = this.getCheckValues();
                this.checkChanges();
            }
            this.setForm = this.$refs.setForm;
            this.destroyForm = this.$refs.destroyForm;
            this.destroyUrl = this.destroyForm.action.slice(0, -1);
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
        picturesContainer: null,
        deleteArtworkForm: null,
        deleteImagesInput: null,
        initPictureList: null,
        init: function () {
            this.dataForm = this.$refs.dataForm;
            this.picturesContainer = this.$refs.picturesContainer;
            this.deleteArtworkForm = this.$refs.deleteArtworkForm;
            this.deleteImagesInput = this.$refs.deleteImagesInput;
            this.initPictureList = this.getPictureList();
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
        deletePicture: function (id) {
            this.picturesContainer.querySelector('#picture-' + id).remove();
        },
        diffPictures: function () {
            let initPicturesList = JSON.parse(this.initPictureList);
            let actualPicturesList = JSON.parse(this.getPictureList());
            return JSON.stringify(initPicturesList.filter(x => !actualPicturesList.includes(x)));
        },
        getPictureList() {
            let imgDivs = this.picturesContainer.childNodes;
            let ids = [];
            imgDivs.forEach((div) => {
                if (div.id) {
                    ids.push(div.id.replace('picture-', ''));
                }
            });
            return JSON.stringify(ids);
        },
        save: function () {
            this.deleteImagesInput.value = this.diffPictures();
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