const togglePwd = () => {
    const pwdInput = document.querySelector("#inputPassword");
    pwdInput.type = pwdInput.type === "text" ? "password" : "text";
    const eyeIcon = document.querySelector("#eye");
    eyeIcon.classList.contains("d-none") ? eyeIcon.classList.remove("d-none") : eyeIcon.classList.add("d-none");
    const eyeSlashIcon = document.querySelector("#eye-slash");
    eyeSlashIcon.classList.contains("d-none") ? eyeSlashIcon.classList.remove("d-none") : eyeSlashIcon.classList.add("d-none");
}

let albums = [];
fetch('https://127.0.0.1:8000/api/albums')
    .then(response => response.json())
    .then(dataAlbums => {
        /*  Iterating Through an Object with `forEach()`  */
        /*  Using Object.entries()  */
        // Object.entries(dataAlbums["hydra:member"]).forEach(entry => {
        //     const [key, value] = entry;
        //     console.log(key, value);
        //   });

        /*  Using Object.values()  */
        // Object.values(dataAlbums["hydra:member"]).forEach(val => {
        //     console.log(val.title);
        // })

        /*  Using Object.keys()  */
        Object.keys(dataAlbums["hydra:member"]).forEach(key => {
            console.log(key, dataAlbums["hydra:member"][key])
        })




        //console.log(dataAlbums["hydra:member"][0].title)
        //return data["hydra:member"]
    })