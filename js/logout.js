function logout() {
    console.log("ok");
    document.getElementById("notLoggedIn").style.display = "flex";
    document.getElementById("loggedIn").style.display = "none";
    deleteCookie("user");
}