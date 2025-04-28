document.addEventListener("DOMContentLoaded", function () {
    // Password visibility toggle
    const toggleBtns = document.querySelectorAll(".password-toggle");

    toggleBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            const target = this.getAttribute("data-target") || "password";
            const passwordField = document.querySelector("#" + target);

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

    // Password strength indicator could be added here
    const passwordField = document.querySelector("#password");
    passwordField.addEventListener("input", function () {
        // Simple password strength logic could go here
    });

    // Password match validation
    const confirmPasswordField = document.querySelector(
        "#password_confirmation"
    );
    confirmPasswordField.addEventListener("input", function () {
        if (this.value !== passwordField.value) {
            this.setCustomValidity("Passwords do not match");
        } else {
            this.setCustomValidity("");
        }
    });
});
