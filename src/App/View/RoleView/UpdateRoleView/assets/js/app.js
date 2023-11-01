document.addEventListener("DOMContentLoaded", ()=> {
    document.getElementById("update-role-form").addEventListener("submit", async (ev)=> {
        ev.preventDefault();

        var url = window.location.href;
        url = url.replace("?", "");
        var urlParts = url.split('/');
        var id = urlParts[urlParts.length - 1];

        updatedRoleName = document.getElementById("role-name-input").value;
        updatedDescription = document.getElementById("role-description-input").value;
        let body = {};
        if (updatedDescription.length == 0){
            body = JSON.stringify({
                name: updatedRoleName
            });
        }else if (updatedRoleName.length == 0){
            body = JSON.stringify({
                description: updatedDescription
            })
        }else{
            body = JSON.stringify({
                name: updatedRoleName,
                description: updatedDescription
            });
        };
        httpConf = {
            method: "POST",
            body: body,
        }
        await fetch(`/api/updaterole/${id}`, httpConf)
        .then((r) => {return r.json()})
        .then((response)=> {
            window.alert(response.message);
        })
        .catch((err)=>{
            window.alert(`Ocorreu um erro ao conectar-se com o servidor.`);
        });
    })
})