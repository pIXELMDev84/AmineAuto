const toggleMenu = document.getElementById("toggleMenu");
const toggelMenuIcon = document.getElementById("toggelMenuIcon");
const sideNav = document.getElementById("sideNav");
const toggleTheme = document.getElementById("toggleTheme");
const toggleThemeIcon = document.getElementById("toggleThemeIcon");

toggleMenu.onclick = (e) => {
    sideNav.classList.toggle("showsideNav");
     toggelMenuIcon.classList.toggle("rotateToggelMenuIcon")
     toggleMenu.classList.toggle("slidetoggleMenu")
}

toggleTheme.onclick = () => {
    document.body.classList.toggle("darkTheme")
    e.target.classList.toggle("lightMoonIcon");
}