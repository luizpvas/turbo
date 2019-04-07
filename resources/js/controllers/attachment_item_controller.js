import { Controller } from "stimulus";
import Alert from "../alert";

export default class extends Controller {
    static targets = ["delete", "copy"];

    connect() {
        this.deleteTarget.addEventListener("click", ev => {
            ev.preventDefault();
            console.log("delete clicked");
        });

        this.copyTarget.addEventListener("click", ev => {
            ev.preventDefault();

            let input = document.createElement("input");
            input.value = this.copyTarget.href;
            document.body.appendChild(input);
            input.select();
            document.execCommand("copy");
            document.body.removeChild(input);

            Alert.successFromElement(
                this.copyTarget,
                "URL copied to the clipboard."
            );
        });
    }
}
