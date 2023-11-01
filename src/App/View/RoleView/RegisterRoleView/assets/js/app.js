document.addEventListener("DOMContentLoaded", ()=> {
    document.getElementById("new-role-form-id").addEventListener("submit", async (ev)=> {
        ev.preventDefault();
    
        roleName = document.getElementById("role-name-input").value;
        roleDescription = document.getElementById("role-description-input").value;
        httpConf = {
            method: "POST",
            body: JSON.stringify({
                name: roleName,
                description: roleDescription
            })
        }
        
        await fetch("/api/registernewrole", httpConf)
        .then((r)=>{return r.json()})
        .then((response)=> {
            window.alert(response.message);
        })
        .catch((err)=> {
            window.alert(`ERROR: ${err}`);
        });
    })



})