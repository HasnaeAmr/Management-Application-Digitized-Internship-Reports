function redirectToLoginPage() {
    window.location.href = "login.php";
}
/*function selectedValue(value) {
   
    if(value==="Student")
        level.style.display = "block";
    else 
        level.style.display = "none";
}*/
function toggleLevel() {
    var level = document.getElementById("level");
    level.style.display = document.getElementsByName('role')[0].checked ? "block" : "none";
}
