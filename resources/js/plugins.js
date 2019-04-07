import { Application } from "stimulus";
import { definitionsFromContext } from "stimulus/webpack-helpers";
const application = Application.start();
const context = require.context("./plugins", true, /\.js$/);
application.load(definitionsFromContext(context));

import Turbolinks from "turbolinks";
Turbolinks.start();
