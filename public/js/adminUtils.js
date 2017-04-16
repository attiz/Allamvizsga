window.onload = function() {
    document.querySelector("#tanar").addEventListener("click", handleViews);
    document.querySelector("#kerdes").addEventListener("click", handleViews);
    document.querySelector("#orarend").addEventListener("click", handleViews);
}

// handleViews
function handleViews(e) {

    if(e.target.id == "tanar") {
        document.querySelector("#tanarok").style.display = "block";
        document.querySelector("#tanarAdatok").style.display = "block";
        document.querySelector("#kerdesek").style.display = "none";
        document.querySelector("#orarendView").style.display = "none";
        document.querySelector("#kerdesAdatok").style.display = "none";

    } else if(e.target.id == "kerdes") {
        document.querySelector("#kerdesek").style.display = "block";
        document.querySelector("#kerdesAdatok").style.display = "block";
        document.querySelector("#tanarok").style.display = "none";
        document.querySelector("#orarendView").style.display = "none";
        document.querySelector("#tanarAdatok").style.display = "none";

    }else if(e.target.id == "orarend") {
        document.querySelector("#orarendView").style.display = "block";
        document.querySelector("#tanarok").style.display = "none";
        document.querySelector("#kerdesek").style.display = "none";
        document.querySelector("#tanarAdatok").style.display = "none";
        document.querySelector("#kerdesAdatok").style.display = "none";
    }
}