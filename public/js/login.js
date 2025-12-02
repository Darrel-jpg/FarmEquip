/* ===== SELECT ELEMENTS ===== */
const container = document.querySelector(".container");
const registerBtn = document.querySelector(".register-btn");
const loginBtn = document.querySelector(".login-btn");
const passwordToggles = document.querySelectorAll(".toggle-password");

/* ===== PANEL TOGGLE HANDLERS ===== */
registerBtn?.addEventListener("click", () => {
    container?.classList.add("active");
});

loginBtn?.addEventListener("click", () => {
    container?.classList.remove("active");
});

/* ===== PASSWORD VISIBILITY TOGGLE ===== */
passwordToggles.forEach((icon) => {
    icon.addEventListener("click", () => {
        const targetId = icon.dataset.target;
        const input = document.getElementById(targetId);

        if (!input) return; // stop jika input tidak ditemukan

        const isPassword = input.type === "password";
        input.type = isPassword ? "text" : "password";

        icon.classList.toggle("fa-eye-slash", !isPassword);
        icon.classList.toggle("fa-eye", isPassword);
    });
});

/* ===== FLASH ALERT AUTO HIDE ===== */
document.addEventListener("DOMContentLoaded", () => {
    const flash = document.getElementById("flash-alert");

    flash &&
        setTimeout(() => {
            flash.classList.add("fade-out");
            setTimeout(() => flash.remove(), 500);
        }, 5000);
});
