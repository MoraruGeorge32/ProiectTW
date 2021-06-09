function status(response) {
    if (response.status >= 200 && response.status < 300) {
        // cererea poate fi rezolvată – fulfill
        return Promise.resolve(response)
    } else {
        // cererea a fost refuzată – reject
        return Promise.reject(new Error(response.statusText))
    }
}

let displayFilters = (id) => {
    if(document.getElementById(id).style.display === "none")
        document.getElementById(id).style.display="flex";
    else
        document.getElementById(id).style.display="none";
}