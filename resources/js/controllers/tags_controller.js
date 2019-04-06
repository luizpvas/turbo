import { Controller } from "stimulus";

export default class extends Controller {
    static targets = ["output"];

    connect() {
        this.tags = [];
        try {
            this.tags = JSON.parse(this.data.get("tags"));
        } catch (err) {}

        let input = this.element.querySelector("input");

        input.addEventListener("keydown", ev => {
            if (ev.keyCode == 13) {
                ev.preventDefault();
                this.addTag(input.value);
                input.value = "";
            }
        });

        this.render();
    }

    addTag(tag) {
        this.tags.push({ tag });
        this.render();
    }

    removeTag(tagLabel) {
        this.tags = this.tags.filter(({ tag }) => tagLabel != tag);
        this.render();
    }

    render() {
        let html = this.tags.map(({ tag }) => {
            return `
            <input type="checkbox" class="hidden" name="tags[]" value="${tag}" checked>
            <div class="inline-block bg-indigo text-white rounded font-bold text-xs py-px px-1">
              ${tag}
              <i class="fas fa-times text-indigo-lighter ml-1 cursor-pointer" data-remove="${tag}"></i>
            </div>
            `;
        });

        this.outputTarget.innerHTML = html.join("");
        Array.from(this.outputTarget.querySelectorAll("[data-remove]")).forEach(
            elm => {
                elm.addEventListener("click", ev => {
                    let tag = elm.getAttribute("data-remove");
                    this.removeTag(tag);
                });
            }
        );
    }
}
