import { Controller } from "stimulus";
import Turbolinks from "turbolinks";
import TurbolinksLaravel from "../turbolinks_laravel";

export default class extends Controller {
    connect() {
        this.submitTarget = this.element.querySelector('button[type="submit"]');
        this.element.addEventListener("submit", this.onSubmit.bind(this));
        this.inputs.forEach(node => {
            node.addEventListener("blur", ev => {
                if (
                    node.classList.contains("field__input--error") &&
                    node.value.length > 0
                ) {
                    this.clearInputValidation(node);
                }
            });
        });
    }

    get inputs() {
        return Array.from(this.element.querySelectorAll(".field input,select"));
    }

    onSubmit(ev) {
        ev.preventDefault();

        if (document.activeElement.tagName == "BUTTON") {
            this.submitTarget = document.activeElement;
        }

        this.clearValidation();
        this.updateSubmitToLoading();
        let data = new FormData(this.element);

        if (this.submitTarget.hasAttribute("data-additional-attributes")) {
            try {
                let attrs = JSON.parse(
                    this.submitTarget.getAttribute("data-additional-attributes")
                );

                Object.keys(attrs).forEach(key => {
                    data.append(key, attrs[key]);
                });
            } catch (err) {}
        }

        fetch(this.element.action, {
            headers: {
                Accept: "application/json"
            },
            body: data,
            method: "post"
        })
            .then(res => res.json())
            .then(res => {
                this.restoreSubmitFromLoading();

                if (TurbolinksLaravel.isRedirect(res)) {
                    TurbolinksLaravel.followRedirect(res);
                } else {
                    this.showValidationErrors(res.errors);
                }
            });
    }

    followRedirect(url) {
        Turbolinks.visit(url, { action: "replace" });
    }

    clearValidation() {
        Array.from(
            this.element.querySelectorAll(".field__input--error")
        ).forEach(this.clearInputValidation);
    }

    clearInputValidation(input) {
        input.classList.remove("field__input--error");
        let validation = input.parentNode.querySelector(".field__validation");
        if (validation) {
            validation.parentNode.removeChild(validation);
        }
    }

    updateSubmitToLoading() {
        this.submitHTML = this.submitTarget.innerHTML;
        this.submitTarget.innerHTML = "Loading...";
    }

    restoreSubmitFromLoading() {
        this.submitTarget.innerHTML = this.submitHTML;
    }

    showValidationErrors(errors) {
        Object.keys(errors).forEach(name => {
            let input = this.element.querySelector(`[name="${name}"]`);
            input.classList.add("field__input--error");

            let field = input.parentNode;
            let error = document.createElement("div");
            error.className = "field__validation";
            error.innerHTML = errors[name];
            field.appendChild(error);
        });
    }
}
