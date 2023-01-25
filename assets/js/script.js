var xhr;

xhr = new XMLHttpRequest();

xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        var data = JSON.parse(xhr.responseText);
                        console.log(data)
                    }
                }
            }
        }
    }
}

xhr.open('POST', '/controller/index-controller.php', true);
xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhr.send(null);

