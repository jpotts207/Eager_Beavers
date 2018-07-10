/**
 * Created by Daniel Bratton on 21/06/2018.
 */
function openContext(){
    alert("You have opened the context!");
}

function checkPasswordsMatch(input)
{
    if(input.value != document.getElementById('password').value)
    {
        input.setCustomValidity('Passwords Must be Matching.');
    }else
        {
        input.setCustomValidity('');
    }
}