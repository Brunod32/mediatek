const togglePwd = () => {
    const pwdInput = document.querySelector("#inputPassword");
    pwdInput.type = pwdInput.type === "text" ? "password" : "text";
    const eyeIcon = document.querySelector("#eye");
    eyeIcon.classList.contains("d-none") ? eyeIcon.classList.remove("d-none") : eyeIcon.classList.add("d-none");
    const eyeSlashIcon = document.querySelector("#eye-slash");
    eyeSlashIcon.classList.contains("d-none") ? eyeSlashIcon.classList.remove("d-none") : eyeSlashIcon.classList.add("d-none");
}