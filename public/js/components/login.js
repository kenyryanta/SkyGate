document.addEventListener("DOMContentLoaded", function () {
    // Password visibility toggle
    const toggleBtn = document.querySelector(".password-toggle");
    const passwordField = document.querySelector("#password");

    toggleBtn.addEventListener("click", function () {
        const type =
            passwordField.getAttribute("type") === "password"
                ? "text"
                : "password";
        passwordField.setAttribute("type", type);

        // Toggle icon
        this.querySelector("i").classList.toggle("bi-eye");
        this.querySelector("i").classList.toggle("bi-eye-slash");
    });
});
