import { Controller } from "stimulus";

export default class extends Controller {
    static targets = ["html", "text"];

    connect() {
        this.ensureTrixLoaded(() => {
            this.element
                .querySelector("trix-editor")
                .addEventListener("trix-change", ev => {
                    this.textTarget.value = this.element
                        .querySelector("trix-editor")
                        .editor.getDocument()
                        .toString();
                });
        });
    }

    ensureTrixLoaded(callback) {
        if (window.Trix) {
            return callback();
        }

        let script = document.createElement("script");
        script.src = "/js/trix.js";
        script.onload = () => {
            let css = document.createElement("link");
            css.rel = "stylesheet";
            css.href = "/css/trix.css";
            css.onload = () => {
                callback();
            };
            document.head.appendChild(css);
        };
        document.head.appendChild(script);
    }
}
