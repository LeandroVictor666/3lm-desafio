document.addEventListener("DOMContentLoaded", ()=> {
    document.getElementById("edit-employee-form-id").addEventListener("submit", async (ev)=> {
        ev.preventDefault();
        let name = document.getElementById("name-input").value;
        let lastName = document.getElementById("lastname-input").value;
        let role = document.getElementById("role-input").value;
        let date = document.getElementById("date-input").value;
        let salary = document.getElementById("salary-input").value;

        let url = window.location.href;
        url = url.replace("?", "");
        let urlParts = url.split("/");
        let id = urlParts[urlParts.length - 1];


        const httpConf = {
            method: "PATCH",
            body: JSON.stringify({
                name: name,
                lastName: lastName,
                role: role,
                birthday: date,
                salary: salary
            })
        };
        await fetch(`/api/editemployee/${id}`, httpConf)
        .then((r) => {return r.json()})
        .then((response) => {window.alert(response.message)})
        .catch((err) => {
            window.alert("Ocorreu um Erro ao se conectar com o servidor, por favor tente novamente, ou contate um admnistrador.");
        });


    });
});