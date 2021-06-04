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
            console.log(this.deleteForm);
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