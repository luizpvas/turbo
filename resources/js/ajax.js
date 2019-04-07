export default {
    post(url, body) {
        return fetch(url, {
            method: "POST",
            headers: {
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content
            },
            body: body
        });
    }
};
