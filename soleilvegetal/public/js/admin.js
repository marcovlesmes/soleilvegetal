window.listedItems = function () {
    return {
        destroyForm: null,
        destroyUrl: null,
        init: function () {
            this.destroyForm = this.$refs.destroyForm;
            this.destroyUrl = this.destroyForm.action.slice(0, -1);
            console.log('Listed Items Init :)');
        },
        destroy: function (id) {
            this.destroyForm.setAttribute('action', this.destroyUrl + id)
            this.destroyForm.submit();
        }
    }
}