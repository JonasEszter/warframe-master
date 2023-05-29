function fetchData(url, method, contentType, data = {}) {
    let fetchObj = {};

    if(method == "GET") {
        fetchObj = {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute("content"),
                'Content-Type': contentType
            }
        };
    } else {
        fetchObj = {
            method: method,
            body:JSON.stringify(data),
            headers: {
                'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute("content"),
                'Content-Type': contentType,
                'X-Requested-With':'XMLHttpRequest'
            }
        };
    }

    return fetch(url, fetchObj);
}

export default fetchData;