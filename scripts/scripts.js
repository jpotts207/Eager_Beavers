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

function confirmPasswordChange(){
    alert("Password changed successfully");
}

function gotoFriends(){
    window.location.href = "index.php?page=friends";
}
function gotoHome(){
    window.location.href = "index.php?page=Home";
}
function gotoLogin(){
    window.location.href = "index.php?page=loginPage";
}

var map;
function loadMapScenario(myMap) {

    map = new Microsoft.Maps.Map(document.getElementById(myMap), {
        zoom : 11
    });
}

function SearchMap(address) {
    Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
        var searchManager = new Microsoft.Maps.Search.SearchManager(map);
        var requestOptions = {
            bounds: map.getBounds(),
            where: address,
            callback: function (answer, userData) {
                map.setView({ bounds: answer.results[0].bestView });
                map.entities.push(new Microsoft.Maps.Pushpin(answer.results[0].location));
            }
        };
        searchManager.geocode(requestOptions);
    });
}

function findAddress(){
    var address = $("#mapSearchBox").val();
    SearchMap(address);
}


//jquery stuff
$(document).ready(function(){
    $(window).keydown(function(event){
        //alert("here" + event.KeyCode);
        if(event.keyCode == 13){
            event.preventDefault();
            return false;
        }
    });

    $('#datePick').multiDatesPicker();
});




