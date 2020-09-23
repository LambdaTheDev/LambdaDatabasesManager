$("#checkAll").click(() => {
    $('.checkAll_subject').not(this).prop('checked', this.checked);
});