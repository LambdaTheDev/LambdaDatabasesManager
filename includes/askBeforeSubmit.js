function ask()
{
    if(confirm('Are you sure that you want to perform this action?'))
    {
        let form = document.getElementById('dangerous_form');
        form.submit();
    }
}
