export default {
    successFromElement(element, message) {
        let { top, left, width, height } = element.getBoundingClientRect();

        let elm = document.createElement("div");
        elm.style.top = window.scrollY + top + height + "px";
        elm.style.left = left + width + "px";
        elm.className =
            "absolute bg-white shadow border rounded p-1 text-sm text-green-dark";
        elm.innerHTML = "&#10004; " + message;
        document.body.appendChild(elm);

        setTimeout(() => {
            document.body.removeChild(elm);
        }, 1000);
    }
};
