function onCheck(checked)
{
    $('.checkAll').map((ignored, checkbox) => {
        $(checkbox).prop('checked', checked);
    }).get();
}