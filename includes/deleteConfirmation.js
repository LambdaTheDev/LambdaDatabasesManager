function deleteAttempt(action)
{
    if(window.confirm("Are you sure that you want to delete this?"))
    {
        document.deleteForm.action = '/actions/delete.php'
    }
}