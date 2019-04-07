import { Controller } from "stimulus";

export default class extends Controller {
    static targets = ["drop", "progress", "output"];

    connect() {
        this.counter = 0;

        this.dropTarget.addEventListener(
            "dragenter",
            ev => {
                this.counter += 1;
                console.log("enter");
                ev.preventDefault();
                ev.stopPropagation();
                this.highlight();
            },
            false
        );

        this.dropTarget.addEventListener(
            "dragleave",
            ev => {
                this.counter -= 1;
                console.log("leave");
                ev.preventDefault();
                ev.stopPropagation();
                if (this.counter == 0) {
                    this.unhighlight();
                }
            },
            false
        );

        this.dropTarget.addEventListener(
            "dragover",
            ev => {
                ev.preventDefault();
                ev.stopPropagation();
            },
            false
        );

        this.dropTarget.addEventListener(
            "drop",
            ev => {
                ev.preventDefault();
                ev.stopPropagation();
                this.unhighlight();

                let files = ev.dataTransfer.files;
                this.uploadFile(files[0]);
            },
            false
        );
    }

    highlight() {
        this.dropTarget.classList.add("text-green");
        this.dropTarget.classList.add("font-bold");
    }

    unhighlight() {
        this.dropTarget.classList.remove("text-green");
        this.dropTarget.classList.remove("font-bold");
    }

    uploadFile(file) {
        let url = `/websites/${this.data.get("websiteId")}/attachments`;
        let xhr = new XMLHttpRequest();
        let data = new FormData();

        xhr.open("POST", url, true);

        xhr.addEventListener("readystatechange", e => {
            if (xhr.readyState == 4 && xhr.status == 200) {
                let data = JSON.parse(xhr.responseText);
                this.outputTarget.insertAdjacentHTML("afterbegin", data.item);
            } else if (xhr.readyState == 4 && xhr.status != 200) {
                console.log("something went wrong");
            }

            this.clearProgress();
        });

        xhr.upload.onprogress = ev => {
            console.log("progress...");
            let pct = Math.ceil((ev.loaded / ev.total) * 100);
            this.renderProgress(pct);
        };

        xhr.setRequestHeader(
            "X-Csrf-Token",
            document.querySelector('meta[name="csrf-token"]').content
        );

        data.append("file", file);
        xhr.send(data);
    }

    renderProgress(pct) {
        this.progressTarget.innerHTML = `
          <div class="bg-grey-light h-4 w-full rounded">
            <div class="bg-blue h-4 rounded" style="width: ${pct}%;"></div>
          </div>
        `;
    }

    clearProgress() {
        this.progressTarget.innerHTML = "";
    }
}
