function validateInput(userInput, minChar = 3, maxChar = 80){
    if (userInput.length < minChar){
        return false;
    }else if (userInput.length > maxChar){
        return false;
    }
    return true;
}

document.addEventListener("DOMContentLoaded", ()=> {
    document.getElementById("new-eployeer-form-id").addEventListener("submit", async (ev)=> {
        ev.preventDefault()
        username = document.getElementById("name-value").value;
        lastName = document.getElementById("lastname-value").value;
        selectedRole = document.getElementById("selected-role").value;
        birthday = document.getElementById("birthday-value").value;
        salaryValue = document.getElementById("salary-value").value;
        if (validateInput(username) === false){
            window.alert("Por favor, insira um nome valido\nQuantidade Minima De Caracteres: 3\nQuantidade Maxima: 80")
            return
        }else if (validateInput(lastName) === false){
            window.alert("Por favor, insira um sobrenome valido\nQuantidade Minima De Caracteres: 3\nQuantidade Maxima: 80")
            return
        }

        const data = {
            'name': username,
            'lastName': lastName,
            'roleId': selectedRole,
            'birthday': birthday,
            'salary': salaryValue
        }
        const httpHeader = {
            method: "POST",
            body: JSON.stringify(data) 
        }
        await fetch("/api/registeremployeer", httpHeader)
        .then((res)=> {return res.json()})
        .then((response)=> {
            window.alert(`${response.message}`)
        })
        .catch((err)=> {
            window.alert("Ocorreu um erro ao tentar conectar-se com o servidor, por favor tente novamente mais tarde ou contate um admnistrador.");
        });
    })

})