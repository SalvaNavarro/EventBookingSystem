function turnAccessible() {
    var styles = document.getElementById("stylesheet");
    var accessibilityLink = document.getElementById("accessibility-link");
    if (styles.href.includes("styles.css")) {
        styles.href = "../assets/stylesheets/stylesAccessible.css";
        accessibilityLink.innerHTML = "Regular page display";
    }
    else {
        styles.href = "../assets/stylesheets/styles.css"
        accessibilityLink.innerHTML = "Accessible Version";
    }
    console.log(styles.href);
}