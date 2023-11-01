document.addEventListener("DOMContentLoaded", ()=> {
    document.getElementById("delete-employee-btn").addEventListener("click", async ()=> {
        if (window.confirm("Voce REALMENTE deseja deletar este funcionario do banco de dados?\n\nAperte OK para sim, ou cancelar para nao") === false){
            window.alert("Operacao abortada com sucesso.")
            return;
        }

        let url = window.location.href;
        urlParts = url.split("/");
        id = urlParts[urlParts.length - 1];

        const httpConf = {
            method: "DELETE"
        };

        await fetch(`/api/deleteemployee/${id}`, httpConf)
        .then((r) => {return r.json()})
        .then((response) => {
            window.alert(response.message);
        })
        .catch((err)=> {
            window.alert("Falha ao conectar-se com o servidor, por favor tente novamente ou contate um admnistrador.");
        })
        
        
    })


})