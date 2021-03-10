// #region Global Imports
const nextRoutes = require("next-routes");
// #endregion Global Imports

const routes = (module.exports = nextRoutes());

routes.add("home", "/");
routes.add("stores", "/stores");
routes.add("store", "/stores/[slug]");

export default routes;
