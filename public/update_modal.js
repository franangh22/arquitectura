document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("upd-modal");
    const btns = document.querySelectorAll(".update");
    const span = document.getElementsByClassName("cerrar")[0];
    btns.forEach(function (btn) {
        btn.onclick = function (event) {
            event.preventDefault();
            modal.style.display = "block";
        }
    });
    span.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});