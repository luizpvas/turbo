import { Controller } from "stimulus";
import Turbolinks from "turbolinks";
import Ajax from "../ajax";

export default class extends Controller {
    connect() {
        this.element.addEventListener("change", ev => {
            switch (this.element.value) {
                case "websites":
                    Turbolinks.visit("/websites");
                    break;
                case "logout":
                    Ajax.post("/logout").then(res => {
                        Turbolinks.visit("/login");
                    });
                    break;
            }
        });
    }
}
