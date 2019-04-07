import { Controller } from "stimulus";

export default class extends Controller {
    connect() {
        this.element.addEventListener("submit", ev => {
            ev.preventDefault();

            let data = new FormData(this.element);
            data.append("mailing_list_id", this.data.get("id"));

            fetch(
                "https://admin.turboroute.app/api/mailing_list_subscriptions",
                {
                    method: "POST",
                    headers: {
                        Accept: "application/json"
                    },
                    body: data
                }
            )
                .then(res => res.text())
                .then(res => {
                    this.element.innerHTML = res;
                });
        });
    }
}
