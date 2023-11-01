document.addEventListener("DOMContentLoaded", ()=> {
    document.getElementById("confirm-delete-btn").addEventListener("click", async ()=> {
        const httpConf = {
            method: "DELETE",
        }
        var url = window.location.href;
        url = url.replace("?", "");
        var urlParts = url.split('/');
        var id = urlParts[urlParts.length - 1];

        await fetch(`/api/deleterole/${id}`, httpConf)
        .then((r) => {return r.json()})
        .then((response) => {window.alert(response.message)})
        .catch((err) => {
            window.alert("Não Foi Possivel Conectar-se ao servidor.")
        });
    })


})