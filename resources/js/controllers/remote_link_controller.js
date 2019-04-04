import { Controller } from "stimulus";
import TurbolinksLaravel from "../turbolinks_laravel";

export default class extends Controller {
    connect() {
        this.element.addEventListener("click", ev => {
            ev.preventDefault();

            fetch(this.element.href, {
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content
                },
                method: this.method
            })
                .then(res => res.json())
                .then(res => {
                    TurbolinksLaravel.followRedirect(res);
                });
        });
    }

    get method() {
        return this.element.getAttribute("data-method") || "GET";
    }
}
