import Turbolinks from "turbolinks";

export default {
  install() {
    document.addEventListener("turbolinks:load", ev => {
      if (this.flash) {
        console.log("applying flash", this.flash);
      }

      this.flash = null;
    });
  },

  isRedirect(json) {
    return json.redirect;
  },

  followRedirect(json) {
    this.flash = json.flash;
    Turbolinks.visit(json.redirect, { action: "replace" });
  }
};
